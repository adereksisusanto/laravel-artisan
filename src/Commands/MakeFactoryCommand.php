<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeFactoryCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:factory {name}';

    protected $description = 'Generate a new model factory class';

    protected function getStubName(): string
    {
        return 'factory.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Database/Factories';
    }
}
