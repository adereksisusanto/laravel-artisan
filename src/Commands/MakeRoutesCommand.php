<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeRoutesCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:routes {name} {--force : Create the file even if the routes file already exists}';

    protected $description = 'Generate a new routes file';

    protected function getStubName(): string
    {
        return 'routes.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'routes';
    }

    protected function getGeneratorKey(): ?string
    {
        return 'routes';
    }

    protected function getPath(string $name): string
    {
        return base_path("routes/{$name}.php");
    }
}
