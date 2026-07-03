<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeRepositoryCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:repository {name} {--force : Create the class even if the repository already exists}';

    protected $description = 'Generate a new repository class';

    protected function getStubName(): string
    {
        return 'repository.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Repositories';
    }

    protected function getGeneratorKey(): ?string
    {
        return 'repository';
    }
}
