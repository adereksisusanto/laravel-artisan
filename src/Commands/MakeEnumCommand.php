<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeEnumCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:enum {name}';

    protected $description = 'Generate a new enum class';

    protected function getStubName(): string
    {
        return 'enum.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Enums';
    }
}
