<?php

namespace Mahmoud217TR\AutoFilesLocalizer\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Mahmoud217TR\AutoFilesLocalizer\AutoFilesLocalizerServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Mahmoud217TR\\AutoFilesLocalizer\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            AutoFilesLocalizerServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('auto-files-localizer.dynamic.enabled', true);
    }
}
