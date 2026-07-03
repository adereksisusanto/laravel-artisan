<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeProviderCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:provider {name} {--force : Create the class even if the provider already exists}';

    protected $description = 'Generate a new service provider class';

    protected function getStubName(): string
    {
        return 'provider.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Providers';
    }

    protected function getGeneratorKey(): ?string
    {
        return 'provider';
    }
}
