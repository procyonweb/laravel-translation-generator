<?php

declare(strict_types=1);

namespace ProcyonWeb\TranslationGenerator\Client;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Output\ConsoleOutput;

class PhraseClient implements ClientInterface
{
    private const BASE_URL = 'https://api.phrase.com/v2/';

    /** @var Client */
    private $client;

    /** @var string|null */
    private $projectId;

    /** @var ConsoleOutput */
    private $output;

    /** @var string */
    private $apiToken;

    public function __construct(ConsoleOutput $output)
    {
        $this->output = $output;
        $apiToken = config('translation.phrase.apiToken', null);
        $projectId = config('translation.phrase.projectId', null);

        if ($apiToken && $projectId) {
            $this->client = new Client(
                [
                    'base_uri' => self::BASE_URL
                ]
            );
            $this->projectId = $projectId;
            $this->apiToken = $apiToken;
        }
    }

    public function isReady(): bool
    {
        return $this->client !== null;
    }

    public function uploadFile(string $data, string $filename, string $langIso): bool
    {
        try {
            $this->client->post(
                sprintf('projects/%s/uploads', $this->projectId),
                [
                    RequestOptions::AUTH => [$this->apiToken, ''],
                    RequestOptions::MULTIPART => [
                        [
                            'name' => 'locale_id',
                            'contents' => $langIso
                        ],
                        [
                            'name' => 'update_translations',
                            'contents' => true
                        ],
                        [
                            'name' => 'file_format',
                            'contents' => 'simple_json'
                        ],
                        [
                            'name' => 'file',
                            'contents' => fopen($filename, 'r')
                        ]
                    ]
                ]
            );
            $this->output->writeln(sprintf('[PHRASE] %s file uploaded.', $filename));

            return true;
        } catch (\Throwable $e) {
            $this->output->writeln(
                sprintf(
                    '[PHRASE] Failed to upload file: %s. %s',
                    $filename,
                    $e->getMessage()
                )
            );
        }

        return false;
    }

    public function downloadFiles(): bool
    {
        try {
            $locales = config('translation.locales', []);

            if (count($locales) === 0) {
                $this->output->writeln('[PHRASE] No locales configured.');
                return false;
            }

            $this->output->writeln(sprintf('[PHRASE] Downloading %d translations.', count($locales)));

            foreach ($locales as $locale) {
                $this->downloadFile($locale);
            }

            return true;
        } catch (\Throwable $e) {
            $this->output->writeln(
                sprintf(
                    '[PHRASE] Failed to download files. %s',
                    $e->getMessage()
                )
            );
        }

        return false;
    }

    private function downloadFile(string $locale): void
    {
        $this->output->writeln(sprintf('[PHRASE] Downloading locale "%s".', $locale));

        $path = resource_path('lang/') . $locale . '.json';
        $file = fopen($path, 'wb');

        $response = $this->client->get(
            sprintf('projects/%s/locales/%s/download', $this->projectId, $locale),
            array_merge_recursive(
                [
                    RequestOptions::AUTH => [$this->apiToken, ''],
                    RequestOptions::SINK => $file,
                    RequestOptions::QUERY => [
                        'file_format' => 'simple_json',
                    ]
                ],
                Config::get('translation.phrase.downloadOptions', [])
            )
        );

        if ($response->getStatusCode() !== 200) {
            throw new \Exception($response->getReasonPhrase());
        }
    }
}