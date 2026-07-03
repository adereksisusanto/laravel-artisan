<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeActionCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:action {name} {--force : Create the class even if the action already exists}';

    protected $description = 'Generate a new action / single-action class';

    protected function getStubName(): string
    {
        return 'action.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Actions';
    }

    protected function getGeneratorKey(): ?string
    {
        return 'action';
    }
}
