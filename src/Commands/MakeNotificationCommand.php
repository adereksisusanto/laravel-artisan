<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

use Illuminate\Support\Str;

class MakeNotificationCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:notification {name} {--markdown= : Create a new Markdown template for the notification} {--force : Create the class even if the notification already exists}';

    protected $description = 'Generate a new notification class';

    protected function getStubName(): string
    {
        return $this->option('markdown') ? 'notification.markdown.stub' : 'notification.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Notifications';
    }

    protected function getGeneratorKey(): ?string
    {
        return 'notification';
    }

    protected function getReplacements(string $name): array
    {
        return [
            '{{ markdownView }}' => $this->option('markdown') ?: 'emails.'.Str::kebab($name),
        ];
    }
}
