<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeEnumCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:enum {name} {--force : Create the class even if the enum already exists}';

    protected $description = 'Generate a new enum class';

    protected function getStubName(): string
    {
        return 'enum.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Enums';
    }

    protected function getGeneratorKey(): ?string
    {
        return 'enum';
    }
}
