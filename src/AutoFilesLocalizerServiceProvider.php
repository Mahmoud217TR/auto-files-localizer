<?php

namespace Mahmoud217TR\AutoFilesLocalizer;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Translation\Translator;
use Mahmoud217TR\AutoFilesLocalizer\Commands\AutoTranslationExtractionCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class AutoFilesLocalizerServiceProvider extends PackageServiceProvider implements DeferrableProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('auto-files-localizer')
            ->hasConfigFile()
            ->hasCommand(AutoTranslationExtractionCommand::class);
    }

    public function packageRegistered()
    {
        $this->app->extend('translator', function (Translator $translantor, Application $app) {
            $loader = $app['translation.loader'];
            $locale = $app->getLocale();
            $translantor = new AutoFilesLocalizer($loader, $locale);
            $translantor->setFallback($app->getFallbackLocale());

            return $translantor;
        }, true);
    }

    public function provides(): array
    {
        return ['translator'];
    }
}
