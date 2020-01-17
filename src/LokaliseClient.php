<?php declare(strict_types=1);

namespace ProcyonWeb\TranslationGenerator;

use Lokalise\LokaliseApiClient;
use Symfony\Component\Console\Output\ConsoleOutput;

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
                ]
            );
            $result = $response->getContent()['result'];
            $this->output->writeln(
                sprintf(
                    '[LOKALISE] %s file uploaded. %d skipped, %d inserted, %d updated',
                    $filename,
                    $result['skipped'],
                    $result['inserted'],
                    $result['updated']
                )
            );
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
}