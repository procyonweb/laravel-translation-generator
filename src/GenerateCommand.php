<?php
declare(strict_types=1);

namespace ProcyonWeb\TranslationGenerator;

use Symfony\Component\Console\Output\ConsoleOutput;

class GenerateCommand extends AbstractCommand
{
    protected $signature = 'translation:generate {lang=en} {--upload}';

    protected $description = 'Generate missing translation strings in php and Vue files';

    public function __construct(ConsoleOutput $output)
    {
        parent::__construct($output);
    }

    public function handle(): void
    {
        $translatables = (new SearchService())->getTranslatableStrings(config('translation.generator.patterns'));
        if ($this->client?->isReady()) {
            $this->client->downloadFiles();
        }

        $lang = $this->argument('lang');
        $fileName = config('translation.generator.lang_dir', 'resources/lang/') . $lang . '.json';
        $jsonFile = file_get_contents($fileName);
        $translations = json_decode($jsonFile, true);

        foreach ($translatables as $translatable) {
            $translatable = str_replace('\\', '', $translatable);
            if (!array_key_exists($translatable, $translations)) {
                $translations[$translatable] = $translatable;
            }
        }

        ksort($translations);
        $content = json_encode($translations, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES);
        file_put_contents($fileName, $content);

        $isUpload = $this->option('upload');
        if ($isUpload && $this->client?->isReady()) {
            $this->client->uploadFile($content, $fileName, $lang);
        }
    }
}