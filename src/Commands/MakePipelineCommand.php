<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakePipelineCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:pipeline {name} {--force : Create the class even if the pipeline already exists}';

    protected $description = 'Generate a new pipeline class';

    protected function getStubName(): string
    {
        return 'pipeline.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Pipelines';
    }

    protected function getGeneratorKey(): ?string
    {
        return 'pipeline';
    }
}
