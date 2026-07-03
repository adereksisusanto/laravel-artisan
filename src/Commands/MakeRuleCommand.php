<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeRuleCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:rule {name} {--implicit : Generate an implicit rule} {--force : Create the class even if the rule already exists}';

    protected $description = 'Generate a new validation rule class';

    protected function getStubName(): string
    {
        return $this->option('implicit') ? 'rule.implicit.stub' : 'rule.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Rules';
    }

    protected function getGeneratorKey(): ?string
    {
        return 'rule';
    }
}
