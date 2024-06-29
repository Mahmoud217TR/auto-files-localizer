<?php

namespace Mahmoud217TR\AutoFilesLocalizer;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class TranslationScanner
{
    protected ?Command $command;

    public function __construct(Command $command = null)
    {
        $this->command = $command;
    }

    public function findAndEvaluate(): void
    {
        $this->getFiles()->each(function ($file) {
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
                try {
                    if (Str::startsWith($function, '@')) {
                        Blade::render($function);
                    } else {
                        eval("{$function};");
                    }
                } catch (Exception $exception) {
                    $message = $exception->getMessage();
                    if (filled($this->command)) {
                        $this->command->error($message);
                    } else {
                        Log::error($message);
                    }
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
