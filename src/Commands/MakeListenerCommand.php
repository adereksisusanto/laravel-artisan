<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeListenerCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:listener {name} {--event= : The event class being listened for} {--queued : Indicates the event listener should be queued} {--force : Create the class even if the listener already exists}';

    protected $description = 'Generate a new event listener class';

    protected function getStubName(): string
    {
        return $this->option('queued') ? 'listener.queued.stub' : 'listener.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Listeners';
    }

    protected function getGeneratorKey(): ?string
    {
        return 'listener';
    }
}
