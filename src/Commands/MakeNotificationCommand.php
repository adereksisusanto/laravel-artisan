<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeNotificationCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:notification {name}';

    protected $description = 'Generate a new notification class';

    protected function getStubName(): string
    {
        return 'notification.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Notifications';
    }
}
