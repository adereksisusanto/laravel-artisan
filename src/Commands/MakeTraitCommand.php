<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeTraitCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:trait {name}';

    protected $description = 'Generate a new trait';

    protected function getStubName(): string
    {
        return 'trait.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Traits';
    }
}
