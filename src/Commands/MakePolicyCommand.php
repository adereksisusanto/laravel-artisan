<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakePolicyCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:policy {name}';

    protected $description = 'Generate a new policy class';

    protected function getStubName(): string
    {
        return 'policy.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Policies';
    }
}
