<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeObserverCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:observer {name} {--model= : The model that the observer applies to} {--force : Create the class even if the observer already exists}';

    protected $description = 'Generate a new observer class';

    protected function getStubName(): string
    {
        return 'observer.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Observers';
    }

    protected function getGeneratorKey(): ?string
    {
        return 'observer';
    }
}
