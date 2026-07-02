<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeJobCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:job {name}';

    protected $description = 'Generate a new queued job class';

    protected function getStubName(): string
    {
        return 'job.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Jobs';
    }
}
