<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeEventCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:event {name} {--force : Create the class even if the event already exists}';

    protected $description = 'Generate a new event class';

    protected function getStubName(): string
    {
        return 'event.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Events';
    }

    protected function getGeneratorKey(): ?string
    {
        return 'event';
    }
}
