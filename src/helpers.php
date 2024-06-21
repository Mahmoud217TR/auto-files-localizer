<?php

if (! function_exists('default_languages_path')) {
    function default_languages_path(): string
    {
        return version_compare(app()->version(), '9.0', '>=')
            ? app()->langPath()
            : resource_path('lang');
    }
}

if (! function_exists('locale_json_file_path')) {
    function locale_json_file_path(string $locale = "", string $languagesDirectory = null): string
    {
        if (is_null($languagesDirectory)) {
            $languagesDirectory = default_languages_path();
        }
        $fileName = "{$locale}.json";
        $directorySeperator = DIRECTORY_SEPARATOR;
        return "{$languagesDirectory}{$directorySeperator}{$fileName}";
    }
}