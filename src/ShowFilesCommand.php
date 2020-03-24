<?php

declare(strict_types=1);

namespace ProcyonWeb\TranslationGenerator;

use Illuminate\Console\Command;

class ShowFilesCommand extends Command
{
    protected $signature = 'translation:show-files';

    protected $description = 'Show result of the file search';

    public function handle(): void
    {
        $files = (new SearchService())->getFiles(config('translation.generator.patterns'));

        foreach ($files as $file) {
            $this->line($file);
        }
    }
}