<?php

namespace Mahmoud217TR\AutoFilesLocalizer\Translators;

use Illuminate\Support\Facades\File;

abstract class AbstractAutoTranslator
{
    protected function getTranslations(string $filePath): array
    {
        if (! File::exists($filePath)) {
            File::put(
                $filePath,
                json_encode((object) [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            );
        }

        return json_decode(File::get($filePath), true);
    }

    protected function getLocaleJsonFilePath(?string $locale = null): string
    {
        return locale_json_file_path($locale, $this->getLanguagesDirectory());
    }

    protected function getLanguagesDirectory(): string
    {
        $langDir = config('auto-files-localizer.path');

        if (! is_dir($langDir)) {
            mkdir($langDir, 0755, true);
        }

        return $langDir;
    }
}
