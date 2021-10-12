<?php

declare(strict_types=1);

namespace ProcyonWeb\TranslationGenerator;

use Symfony\Component\Console\Output\ConsoleOutput;

class DownloadCommand extends AbstractCommand
{
    protected $signature = 'translation:download';

    protected $description = 'Download all translation json files from selected source';

    public function __construct(ConsoleOutput $output)
    {
        parent::__construct($output);
    }

    public function handle(): void
    {
        $this->info('[Translation Generator] Downloading files...');
        if ($this->client?->isReady()) {
            $this->client->downloadFiles();
        } else {
            $this->error('[Translation Generator] Please check Lokalise config.');
        }
    }
}