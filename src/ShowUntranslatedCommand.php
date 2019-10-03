<?php declare(strict_types=1);

namespace ProcyonWeb\TranslationGenerator;

use Illuminate\Console\Command;

class ShowUntranslatedCommand extends Command
{
    protected $signature = 'translation:show-missing {lang=hu}';

    protected $description = 'Show untranslated strings';

    public function handle(): void
    {
        $lang = $this->argument('lang');
        $jsonFile = file_get_contents('resources/lang/' . $lang . '.json');
        $translations = json_decode($jsonFile, true);

        $count = 0;
        foreach ($translations as $key => $value) {
            if ($key === $value) {
                $this->line($value);
                $count++;
            }
        }

        $this->info('Untranslated lines: ' . $count);
    }
}