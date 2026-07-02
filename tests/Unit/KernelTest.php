<?php

use Adereksisusanto\Laravel\Artisan\Application;
use Adereksisusanto\Laravel\Artisan\Commands\BuildCommand;
use Adereksisusanto\Laravel\Artisan\Commands\InspectCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeActionCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeArtisanCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeDTOCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeEnumCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeInterfaceCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeRepositoryCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeServiceCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeTraitCommand;
use Adereksisusanto\Laravel\Artisan\Kernel;

test('registers all builtin commands', function () {
    $expected = [
        MakeActionCommand::class,
        MakeArtisanCommand::class,
        MakeDTOCommand::class,
        MakeEnumCommand::class,
        MakeInterfaceCommand::class,
        MakeRepositoryCommand::class,
        MakeServiceCommand::class,
        MakeTraitCommand::class,
        BuildCommand::class,
        InspectCommand::class,
    ];

    $reflection = new ReflectionClass(Kernel::class);
    $property = $reflection->getProperty('commands');
    $property->setAccessible(true);

    $kernel = new Kernel(Application::create());
    $commands = $property->getValue($kernel);

    foreach ($expected as $command) {
        expect($commands)->toContain($command);
    }
});

test('can register additional commands', function () {
    $kernel = new Kernel(Application::create());
    $kernel->registerCommand(MakeActionCommand::class);

    $reflection = new ReflectionClass(Kernel::class);
    $property = $reflection->getProperty('commands');
    $property->setAccessible(true);
    $commands = $property->getValue($kernel);

    expect($commands)->toContain(MakeActionCommand::class);
});

test('can register multiple commands', function () {
    $kernel = new Kernel(Application::create());
    $kernel->registerCommands([
        MakeActionCommand::class,
        MakeServiceCommand::class,
    ]);

    $reflection = new ReflectionClass(Kernel::class);
    $property = $reflection->getProperty('commands');
    $property->setAccessible(true);
    $commands = $property->getValue($kernel);

    expect($commands)->toContain(MakeActionCommand::class);
    expect($commands)->toContain(MakeServiceCommand::class);
});

test('bootstrap adds all commands to application', function () {
    $app = Application::create();
    $kernel = new Kernel($app);

    $reflection = new ReflectionClass(Kernel::class);
    $bootstrapMethod = $reflection->getMethod('bootstrap');
    $bootstrapMethod->setAccessible(true);
    $bootstrapMethod->invoke($kernel);

    expect($app->has('make:action'))->toBeTrue();
    expect($app->has('make:command'))->toBeTrue();
    expect($app->has('make:dto'))->toBeTrue();
    expect($app->has('make:enum'))->toBeTrue();
    expect($app->has('make:interface'))->toBeTrue();
    expect($app->has('make:repository'))->toBeTrue();
    expect($app->has('make:service'))->toBeTrue();
    expect($app->has('make:trait'))->toBeTrue();
    expect($app->has('app:build'))->toBeTrue();
    expect($app->has('app:inspect'))->toBeTrue();
});
