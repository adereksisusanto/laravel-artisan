<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeDTOCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:dto {name} {--force : Create the class even if the DTO already exists}';

    protected $description = 'Generate a new Data Transfer Object (DTO) class';

    protected function getStubName(): string
    {
        return 'dto.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'DTOs';
    }

    protected function getGeneratorKey(): ?string
    {
        return 'dto';
    }
}
