<?php

namespace Mahmoud217TR\AutoFilesLocalizer;

use Illuminate\Translation\Translator;
use Mahmoud217TR\AutoFilesLocalizer\Translators\AutoDynamicTranslator;
use Mahmoud217TR\AutoFilesLocalizer\Translators\AutoExtractionTranslator;

class AutoFilesLocalizer extends Translator
{
    protected AutoDynamicTranslator $dynamicTranslator;

    protected AutoExtractionTranslator $extractionTranslator;

    public function get($key, array $replace = [], $locale = null, $fallback = true)
    {
        $language = $locale ?: $this->locale;

        if (filled($language) && $this->inDynamicMode()) {
            $this->getDynamicTranslator()->saveTranslation($key, $language);
        }

        if (filled($language) && $this->inExtractionMode($language)) {
            $this->getExtractionTranslator($language)->addTranslation($key);
        }

        return parent::get($key, $replace, $locale, $fallback);
    }

    protected function getDynamicTranslator(): AutoDynamicTranslator
    {
        if (! isset($this->dynamicTranslator)) {
            return $this->dynamicTranslator = new AutoDynamicTranslator();
        }

        return $this->dynamicTranslator;
    }

    public function getExtractionTranslator(?string $locale = null): AutoExtractionTranslator
    {
        if (! isset($this->extractionTranslator)) {
            return $this->extractionTranslator = new AutoExtractionTranslator($locale);
        }

        return $this->extractionTranslator;
    }

    protected function inDynamicMode(): bool
    {
        return config('auto-files-localizer.dynamic.enabled') &&
            (config('auto-files-localizer.dynamic.production') || ! app()->environment('production'));
    }

    protected function inExtractionMode(string $language): bool
    {
        return config('auto-files-localizer.extraction.enabled') &&
        config('auto-files-localizer.extraction.locale') == $language;
    }
}
