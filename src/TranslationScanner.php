<?php

namespace Mahmoud217TR\AutoFilesLocalizer;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

class TranslationScanner
{
    public function findAndEvaluate():void
    {
        $this->getFiles()->each(function($file) {
            $this->extractFunctionCalls($file, config('auto-files-localizer.extraction.functions'));
        });
    }

    protected function getFiles(): Collection
    {
        $directories = array_map(static function ($dir) {
            return base_path($dir);
        }, config('auto-files-localizer.extraction.directories'));

        return new Collection(
            (new Finder)->in($directories)
                ->name(config('auto-files-localizer.extraction.patterns'))
                ->files()
        );
    }

    protected function extractFunctionCalls(SplFileInfo $file, array $functions): array
    {
        $contents = $file->getContents();

        foreach ($functions as $function) {
            if (preg_match_all($this->functionPattern($function), $contents, $matches)) {
                $function = $matches[0][0];
                if(Str::startsWith($function, '@')) {
                    Blade::render($function);
                } else {
                    eval("{$function};");
                }
            }
        }

        return [];
    }

    protected function functionPattern(string $function): string
    {
        return "/({$function})\\s*\\((.*)\\)/Us";
    }
}
