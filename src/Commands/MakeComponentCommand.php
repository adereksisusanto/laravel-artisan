<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeComponentCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:component {name}';

    protected $description = 'Generate a new view component class';

    protected function getStubName(): string
    {
        return 'component.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'View/Components';
    }
}
