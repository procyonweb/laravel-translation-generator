<?php

declare(strict_types=1);

namespace ProcyonWeb\TranslationGenerator;

use Illuminate\Console\Command;

class ShowUntranslatedCommand extends Command
{
    protected $signature = 'translation:show-missing {lang=fr}';

    protected $description = 'Show untranslated strings';

    public function handle(): void
    {
        $lang = $this->argument('lang');

        if (!file_exists('resources/lang/' . $lang . '.json')) {
            $this->error($lang . '.json doesn\'t exist');
            return;
        }

        $jsonFile = file_get_contents('resources/lang/' . $lang . '.json');

        $count = collect(json_decode($jsonFile, true))
            ->filter(
                function ($value, $key) {
                    return $key === $value;
                }
            )->each(
                function ($value) {
                    $this->line($value);
                }
            )->count();

        $this->info('Untranslated lines: ' . $count);
    }
}