<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeLanguageCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:lang {name} {--locale=en : The locale for the language file} {--force : Create the file even if the language file already exists}';

    protected $description = 'Generate a new language file';

    protected function getStubName(): string
    {
        return 'language.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'lang';
    }

    protected function getGeneratorKey(): ?string
    {
        return 'lang';
    }

    protected function getPath(string $name): string
    {
        $locale = $this->option('locale') ?: 'en';

        return base_path("lang/{$locale}/{$name}.php");
    }

    protected function getReplacements(string $name): array
    {
        return [
            '{{ locale }}' => $this->option('locale') ?: 'en',
        ];
    }
}
