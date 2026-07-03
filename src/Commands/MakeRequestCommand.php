<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeRequestCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:request {name} {--force : Create the class even if the request already exists}';

    protected $description = 'Generate a new form request class';

    protected function getStubName(): string
    {
        return 'request.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Http/Requests';
    }

    protected function getGeneratorKey(): ?string
    {
        return 'request';
    }
}
