<?php declare(strict_types=1);

namespace Kg4b0r\TranslationGenerator;

use Illuminate\Console\Command;

class ShowUntranslatedCommand extends Command
{
    protected $signature = 'translation:show-missing {lang=hu}';

    protected $description = 'Show untranslated strings';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
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