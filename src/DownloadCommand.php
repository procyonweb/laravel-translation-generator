<?php

declare(strict_types=1);

namespace ProcyonWeb\TranslationGenerator;

use Illuminate\Console\Command;

class DownloadCommand extends Command
{
    protected $signature = 'translation:download';

    protected $description = 'Download all translation json files from Lokalise';

    /** @var PhraseClient */
    private $client;

    public function __construct(PhraseClient $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    public function handle(): void
    {
        $this->info('[PHRASE] Downloading files...');
        if ($this->client->isReady()) {
            $this->client->downloadFiles();
        } else {
            $this->error('[PHRASE] Please check Lokalise config.');
        }
    }
}