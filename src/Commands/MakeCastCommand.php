<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeCastCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:cast {name} {--force : Create the class even if the cast already exists}';

    protected $description = 'Generate a new custom Eloquent cast class';

    protected function getStubName(): string
    {
        return 'cast.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Casts';
    }

    protected function getGeneratorKey(): ?string
    {
        return 'cast';
    }
}
