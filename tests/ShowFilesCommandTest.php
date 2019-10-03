<?php declare(strict_types=1);

namespace ProcyonWeb\TranslationGenerator\Test;

class ShowFilesCommandTest extends TestCase
{
    public function test_console_command(): void
    {
        config(['translation.generator.patterns' => []]);

        $this->artisan('translation:show-files')
            ->assertExitCode(0);
    }
}