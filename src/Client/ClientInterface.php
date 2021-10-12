<?php

declare(strict_types=1);

namespace ProcyonWeb\TranslationGenerator\Client;

interface ClientInterface
{
    public function isReady(): bool;

    public function uploadFile(string $data, string $filename, string $langIso): bool;

    public function downloadFiles(): bool;
}