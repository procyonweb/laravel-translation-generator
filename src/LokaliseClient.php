<?php declare(strict_types=1);

namespace ProcyonWeb\TranslationGenerator;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Lokalise\LokaliseApiClient;
use Symfony\Component\Console\Output\ConsoleOutput;
use ZipArchive;

class LokaliseClient
{
    /** @var LokaliseApiClient */
    private $client;

    /** @var string|null */
    private $projectId;
    /**
     * @var ConsoleOutput
     */
    private $output;

    public function __construct(ConsoleOutput $output)
    {
        $this->output = $output;
        $apiToken = config('translation.lokalise.apiToken');
        $projectId = config('translation.lokalise.projectId');

        if ($apiToken && $projectId) {
            $this->client = new LokaliseApiClient($apiToken);
            $this->projectId = $projectId;
        }
    }

    public function isReady(): bool
    {
        return $this->client !== null;
    }

    public function uploadFile(string $data, string $filename, string $langIso): bool
    {
        try {
            $response = $this->client->files->upload(
                $this->projectId,
                [
                    'data' => base64_encode($data),
                    'filename' => $filename,
                    'lang_iso' => $langIso,
                    'slashn_to_linebreak' => true,
                    'queue' => true
                ]
            );
            $this->output->writeln(
                sprintf(
                    '[LOKALISE] %s file uploaded and queued.',
                    $filename
                )
            );

            return true;
        } catch (\Lokalise\Exceptions\LokaliseResponseException $e) {
            $this->output->writeln(
                sprintf(
                    '[LOKALISE] Failed to upload file: %s. %s',
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
            $response = $this->client->files->download(
                $this->projectId,
                array_merge(
                    [
                        'format' => 'json',
                        'original_filenames' => false,
                        'bundle_structure' => '%LANG_ISO%.%FORMAT%',
                        'export_empty_as' => 'base',
                    ],
                    Config::get('translation.lokalise.downloadOptions', [])
                )
            );
            $bundleUrl = $response->getContent()['bundle_url'];

            $this->output->writeln(sprintf('[LOKALISE] Downloading translations from bundle url: %s', $bundleUrl));

            $path = storage_path().'locale.zip';
            $file = fopen($path, 'wb');
            $client = new Client();
            $client->get($bundleUrl, ['save_to' => $file]);

            $zip = new ZipArchive;
            $zip->open($path);
            $zip->extractTo(resource_path('lang'));
            $zip->close();

            unlink($path);

            $this->output->writeln('[LOKALISE] Translations successfully downloaded.');

            return true;
        } catch (\Throwable $e) {
            $this->output->writeln(
                sprintf(
                    '[LOKALISE] Failed to download files. %s',
                    $e->getMessage()
                )
            );
        }

        return false;
    }
}