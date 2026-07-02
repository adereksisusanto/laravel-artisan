<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeChannelCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:channel {name}';

    protected $description = 'Generate a new broadcast channel class';

    protected function getStubName(): string
    {
        return 'channel.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Broadcasting';
    }
}
