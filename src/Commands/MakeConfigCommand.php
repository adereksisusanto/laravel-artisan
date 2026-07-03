<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeConfigCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:config {name} {--force : Create the file even if the config already exists}';

    protected $description = 'Generate a new configuration file';

    protected function getStubName(): string
    {
        return 'config.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'config';
    }

    protected function getGeneratorKey(): ?string
    {
        return 'config';
    }

    protected function getPath(string $name): string
    {
        return base_path("config/{$name}.php");
    }
}
