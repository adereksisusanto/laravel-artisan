<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeJobCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:job {name} {--sync : Indicates that job should be synchronous} {--force : Create the class even if the job already exists}';

    protected $description = 'Generate a new queued job class';

    protected function getStubName(): string
    {
        return $this->option('sync') ? 'job.sync.stub' : 'job.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Jobs';
    }

    protected function getGeneratorKey(): ?string
    {
        return 'job';
    }
}
