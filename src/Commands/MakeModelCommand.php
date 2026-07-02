<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeModelCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:model {name}';

    protected $description = 'Generate a new Eloquent model class';

    protected function getStubName(): string
    {
        return 'model.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Models';
    }
}
