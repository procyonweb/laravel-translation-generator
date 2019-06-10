<?php declare(strict_types=1);

namespace Kg4b0r\TranslationGenerator;

use Illuminate\Console\Command;

class ShowFilesCommand extends Command
{
    protected $signature = 'translation:show-files';

    protected $description = 'Show result of the file search';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $files = (new SearchService())->getFiles(ServiceProvider::SEARCH_PATTERN);

        foreach ($files as $file) {
            $this->line($file);
        }
    }
}