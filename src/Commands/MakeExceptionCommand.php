<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeExceptionCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:exception {name}';

    protected $description = 'Generate a new exception class';

    protected function getStubName(): string
    {
        return 'exception.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Exceptions';
    }
}
