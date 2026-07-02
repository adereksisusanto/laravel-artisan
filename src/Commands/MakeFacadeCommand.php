<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeFacadeCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:facade {name}';

    protected $description = 'Generate a new facade class';

    protected function getStubName(): string
    {
        return 'facade.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Facades';
    }
}
