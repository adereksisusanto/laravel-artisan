<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeObserverCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:observer {name}';

    protected $description = 'Generate a new observer class';

    protected function getStubName(): string
    {
        return 'observer.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Observers';
    }
}
