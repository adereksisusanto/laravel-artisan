<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeArtisanCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:command {name}';

    protected $description = 'Generate a new artisan command class';

    protected function getStubName(): string
    {
        return 'command.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Commands';
    }
}
