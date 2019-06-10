<?php declare(strict_types=1);

namespace Kg4b0r\TranslationGenerator;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    const SEARCH_PATTERN = '{app/{**/*.php,*.php},resources/views/{**/*.php,*.php},resources/js/{**/*,*}/*.vue}';

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateCommand::class,
                ShowFilesCommand::class,
            ]);
        }
    }

}