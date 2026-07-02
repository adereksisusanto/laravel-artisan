<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeInterfaceCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:interface {name}';

    protected $description = 'Generate a new interface';

    protected function getStubName(): string
    {
        return 'interface.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Contracts';
    }
}
