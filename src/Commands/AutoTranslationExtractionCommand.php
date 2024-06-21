<?php

namespace Mahmoud217TR\AutoFilesLocalizer\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Mahmoud217TR\AutoFilesLocalizer\TranslationScanner;

class AutoTranslationExtractionCommand extends Command
{
    use ConfirmableTrait;

    public $signature = 'localizer:extract {language?}';

    public $description = 'Generate json translation files found in the scanned files.';

    public function handle(TranslationScanner $scanner): int
    {
        if (! $this->confirmToProceed()) {
            return 1;
        }

        $locale = $this->getLocale();
        app()->setLocale($locale);
        config()->set('auto-files-localizer.extraction.enabled', true);
        config()->set('auto-files-localizer.extraction.locale', $locale);
        config()->set('auto-files-localizer.dynamic.enabled', false);

        $scanner->findAndEvaluate();

        app()->translator->getExtractionTranslator()->saveTranslations();

        return self::SUCCESS;
    }

    protected function getLocale(): string
    {
        return $this->argument('language') ?? config('app.locale');
    }
}
