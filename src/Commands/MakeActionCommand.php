<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeActionCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:action {name}';

    protected $description = 'Generate a new action / single-action class';

    protected function getStubName(): string
    {
        return 'action.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Actions';
    }
}
