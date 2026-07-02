<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeRequestCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:request {name}';

    protected $description = 'Generate a new form request class';

    protected function getStubName(): string
    {
        return 'request.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Http/Requests';
    }
}
