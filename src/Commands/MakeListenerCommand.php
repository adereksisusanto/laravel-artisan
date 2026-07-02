<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeListenerCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:listener {name}';

    protected $description = 'Generate a new event listener class';

    protected function getStubName(): string
    {
        return 'listener.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Listeners';
    }
}
