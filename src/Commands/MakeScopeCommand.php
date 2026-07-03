<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeScopeCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:scope {name} {--force : Create the class even if the scope already exists}';

    protected $description = 'Generate a new Eloquent query scope class';

    protected function getStubName(): string
    {
        return 'scope.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Scopes';
    }

    protected function getGeneratorKey(): ?string
    {
        return 'scope';
    }
}
