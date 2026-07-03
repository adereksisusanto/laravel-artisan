<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeInterfaceCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:interface {name} {--force : Create the class even if the interface already exists}';

    protected $description = 'Generate a new interface';

    protected function getStubName(): string
    {
        return 'interface.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Contracts';
    }

    protected function getGeneratorKey(): ?string
    {
        return 'interface';
    }
}
