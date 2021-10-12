<?php

declare(strict_types=1);

namespace ProcyonWeb\TranslationGenerator;

use Illuminate\Console\Command;
use ProcyonWeb\TranslationGenerator\Client\ClientInterface;
use ProcyonWeb\TranslationGenerator\Client\PhraseClient;
use Symfony\Component\Console\Output\ConsoleOutput;

class AbstractCommand extends Command
{
    protected ?ClientInterface $client = null;

    public function __construct(ConsoleOutput $output)
    {
        parent::__construct();
        $this->initClient($output);
    }

    private function initClient(ConsoleOutput $output)
    {
        match (config('translation.client')) {
            'phrase' => $this->client = new PhraseClient($output),
            null => null
        };
    }
}