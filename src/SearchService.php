<?php declare(strict_types=1);

namespace ProcyonWeb\TranslationGenerator;

use Illuminate\Support\Collection;

class SearchService
{
    public function getTranslatableStrings(array $patterns): array
    {
        $translations = [];
        $files = $this->getFiles($patterns);

        foreach ($files as $file) {
            $handle = fopen($file, 'rb');
            $text = fread($handle, filesize($file));

            $re = '/(?:\_\_|\$t)\(\\\'((?:.(?!(?<![\\\\])\\\'))*.?)/m';
            preg_match_all($re, $text, $matches, PREG_SET_ORDER, 0);

            foreach ($matches as $match) {
                $translations[] = $match[1];
            }

        }

        return array_unique($translations);
    }

    public function getFiles(array $patterns): Collection
    {
        $files = new Collection();

        foreach ($patterns as $path => $pattern)
        {
            $directory = new \RecursiveDirectoryIterator($path);
            $iterator = new \RecursiveIteratorIterator($directory);
            $regexIterator = new \RegexIterator($iterator, $pattern, \RecursiveRegexIterator::GET_MATCH);
            $fileArray = new Collection(iterator_to_array($regexIterator));
            $files = $files->merge($fileArray->flatten());
        }

        return $files;
    }
}
