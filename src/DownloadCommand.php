<?php declare(strict_types=1);

namespace ProcyonWeb\TranslationGenerator;

use Illuminate\Console\Command;

class DownloadCommand extends Command
{
    protected $signature = 'translation:download';

    protected $description = 'Download all translation json files from Lokalise';

    /** @var LokaliseClient */
    private $lokaliseClient;

    public function __construct(LokaliseClient $lokaliseClient)
    {
        parent::__construct();
        $this->lokaliseClient = $lokaliseClient;
    }

    public function handle(): void
    {
        $this->info('[LOKALISE] Downloading files...');
        if ($this->lokaliseClient->isReady()) {
            $this->lokaliseClient->downloadFiles();
        } else {
            $this->error('[LOKALISE] Please check Lokalise config.');
        }
    }
}