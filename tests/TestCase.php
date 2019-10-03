<?php declare(strict_types=1);

namespace ProcyonWeb\TranslationGenerator\Test;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as Orchestra;
use ProcyonWeb\TranslationGenerator\ServiceProvider;

class TestCase extends Orchestra
{
    /**
     * @param Application $app
     *
     * @return array
     */
    protected function getPackageProviders(Application $app): array
    {
        return [ServiceProvider::class];
    }
}