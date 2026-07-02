<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeSeederCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:seeder {name}';

    protected $description = 'Generate a new seeder class';

    protected function getStubName(): string
    {
        return 'seeder.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Database/Seeders';
    }
}
