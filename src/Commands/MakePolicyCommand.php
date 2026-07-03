<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakePolicyCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:policy {name} {--model= : The model that the policy applies to} {--guard= : The guard that the policy relies on} {--force : Create the class even if the policy already exists}';

    protected $description = 'Generate a new policy class';

    protected function getStubName(): string
    {
        return 'policy.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Policies';
    }

    protected function getGeneratorKey(): ?string
    {
        return 'policy';
    }
}
