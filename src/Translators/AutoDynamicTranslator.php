<?php

namespace Mahmoud217TR\AutoFilesLocalizer\Translators;

use Illuminate\Support\Facades\File;

class AutoDynamicTranslator extends AbstractAutoTranslator
{
    public function saveTranslation(string $key = null, string $locale): void
	{
        $filePath = $this->getLocaleJsonFilePath($locale);
        $translations = $this->getTranslations($filePath);

        if (!isset($translations[$key])) {
            $translations[$key] = $key;
            ksort($translations);
            File::put($filePath, json_encode((object)$translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
	}
}
