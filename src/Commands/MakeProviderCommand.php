<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeProviderCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:provider {name}';

    protected $description = 'Generate a new service provider class';

    protected function getStubName(): string
    {
        return 'provider.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Providers';
    }
}
