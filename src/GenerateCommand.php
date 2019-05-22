<?php declare(strict_types=1);

namespace Kg4b0r\TranslationGenerator;

use Illuminate\Console\Command;

class GenerateCommand extends Command
{
    protected $signature = 'translation:generate';

    protected $description = 'Generate missing translation strings in php and Vue files';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $translatables = (new SearchService())->getTranslatableStrings('{app/**/*.php,resources/views/**/*.php,resources/js/components/**/*.vue}');

        $jsonFile = file_get_contents('resources/lang/hu.json');
        $translations = json_decode($jsonFile, true);

        foreach ($translatables as $translatable) {
            $translatable = str_replace('\\','', $translatable);
            if(!array_key_exists($translatable, $translations))
            {
                $translations[$translatable] = $translatable;
            }
        }

        file_put_contents('resources/lang/hu.json', json_encode($translations, JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE+JSON_UNESCAPED_SLASHES));
    }
}