<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeMailCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:mail {name}';

    protected $description = 'Generate a new mailable class';

    protected function getStubName(): string
    {
        return 'mail.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Mail';
    }
}
