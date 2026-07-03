<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeResourceCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:resource {name} {--model= : The model that the resource applies to} {--collection : Create a collection resource} {--force : Create the class even if the resource already exists}';

    protected $description = 'Generate a new API resource class';

    protected function getStubName(): string
    {
        return $this->option('collection') ? 'resource.collection.stub' : 'resource.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Http/Resources';
    }

    protected function getGeneratorKey(): ?string
    {
        return 'resource';
    }
}
