<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeSeederCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:seeder {name} {--force : Create the class even if the seeder already exists}';

    protected $description = 'Generate a new seeder class';

    protected function getStubName(): string
    {
        return 'seeder.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Database/Seeders';
    }

    protected function getPath(string $name): string
    {
        return database_path('seeders/'.$name.'.php');
    }

    protected function getGeneratorKey(): ?string
    {
        return 'seeder';
    }
}
