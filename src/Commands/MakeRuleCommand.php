<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeRuleCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:rule {name}';

    protected $description = 'Generate a new validation rule class';

    protected function getStubName(): string
    {
        return 'rule.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Rules';
    }
}
