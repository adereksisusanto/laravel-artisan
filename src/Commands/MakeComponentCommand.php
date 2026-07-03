<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeComponentCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:component {name} {--force : Create the class even if the component already exists}';

    protected $description = 'Generate a new view component class';

    protected function getStubName(): string
    {
        return 'component.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'View/Components';
    }

    protected function getGeneratorKey(): ?string
    {
        return 'component';
    }
}
