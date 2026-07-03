<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeServiceCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:service {name} {--force : Create the class even if the service already exists}';

    protected $description = 'Generate a new service class';

    protected function getStubName(): string
    {
        return 'service.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Services';
    }

    protected function getGeneratorKey(): ?string
    {
        return 'service';
    }
}
