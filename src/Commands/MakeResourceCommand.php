<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeResourceCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:resource {name}';

    protected $description = 'Generate a new API resource class';

    protected function getStubName(): string
    {
        return 'resource.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Http/Resources';
    }
}
