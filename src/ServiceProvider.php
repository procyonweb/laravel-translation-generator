<?php declare(strict_types=1);

namespace ProcyonWeb\TranslationGenerator;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/translation.php',
            'laravel_translation_generator'
        );

        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateCommand::class,
                ShowFilesCommand::class,
                ShowUntranslatedCommand::class,
            ]);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/translation.php' => config_path('translation.php'),
        ], 'laravel_translation_generator-config');
    }
}