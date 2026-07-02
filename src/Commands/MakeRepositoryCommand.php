<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeRepositoryCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:repository {name}';

    protected $description = 'Generate a new repository class';

    protected function getStubName(): string
    {
        return 'repository.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Repositories';
    }
}
