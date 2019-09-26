<?php declare(strict_types=1);

namespace Kg4b0r\TranslationGenerator;

class SearchService
{
    public function getTranslatableStrings(array $patterns): array
    {
        $translations = [];
        $files = $this->getFiles($patterns);

        foreach ($files as $file) {
            $handle = fopen($file, 'r');
            $text = fread($handle, filesize($file));

            $re = '/(?:\_\_|\$t)\(\\\'((?:.(?!(?<![\\\\])\\\'))*.?)/m';
            preg_match_all($re, $text, $matches, PREG_SET_ORDER, 0);

            foreach ($matches as $match) {
                $translations[] = $match[1];
            }
        }

        return array_unique($translations);
    }

    public function getFiles(array $patterns): array
    {
        $pattern = '{' . implode(',', $patterns) . '}';

        return glob($pattern, GLOB_BRACE);
    }
}