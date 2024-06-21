<?php

namespace Mahmoud217TR\AutoFilesLocalizer\Translators;

use Illuminate\Support\Facades\File;

class AutoExtractionTranslator extends AbstractAutoTranslator
{
    protected ?string $locale;
    protected string $localeFilePath;
    protected array $translations;

    public function __construct(string $locale = null)
    {
        $this->locale = $locale;
        if (filled($this->locale)) {
            $this->localeFilePath = $this->getLocaleJsonFilePath($this->locale);
            $this->translations = $this->getTranslations($this->localeFilePath);
        }
    }

    public function addTranslation(string $key): void
	{
        if (!isset($this->translations[$key])) {
            $this->translations[$key] = $key;
        }
	}

    public function saveTranslations(): void
    {
        if (filled($this->locale)) {
            ksort($this->translations);
            File::put(
                $this->localeFilePath,
                json_encode((object)$this->translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            );
        }
    }
}
