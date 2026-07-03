<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

use Illuminate\Support\Str;

class MakeMailCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:mail {name} {--markdown= : Create a new Markdown template for the mailable} {--force : Create the class even if the mailable already exists}';

    protected $description = 'Generate a new mailable class';

    protected function getStubName(): string
    {
        return $this->option('markdown') ? 'mail.markdown.stub' : 'mail.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Mail';
    }

    protected function getGeneratorKey(): ?string
    {
        return 'mail';
    }

    protected function getReplacements(string $name): array
    {
        return [
            '{{ markdownView }}' => $this->option('markdown') ?: 'emails.'.Str::kebab($name),
        ];
    }
}
