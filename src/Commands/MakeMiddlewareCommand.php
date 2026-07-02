<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeMiddlewareCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:middleware {name}';

    protected $description = 'Generate a new middleware class';

    protected function getStubName(): string
    {
        return 'middleware.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Http/Middleware';
    }
}
