<?php

use Adereksisusanto\Laravel\Artisan\Application;
use Adereksisusanto\Laravel\Artisan\Commands\BuildCommand;
use Adereksisusanto\Laravel\Artisan\Commands\InspectCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeActionCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeArtisanCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeCastCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeChannelCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeComponentCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeDTOCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeEnumCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeEventCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeExceptionCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeFacadeCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeFactoryCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeInterfaceCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeJobCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeListenerCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeMailCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeMiddlewareCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeMigrationCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeModelCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeNotificationCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeObserverCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakePipelineCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakePolicyCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeProviderCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeRepositoryCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeRequestCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeResourceCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeRuleCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeScopeCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeSeederCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeServiceCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeTraitCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeViewCommand;
use Adereksisusanto\Laravel\Artisan\Kernel;

test('registers all builtin commands', function () {
    $expected = [
        MakeActionCommand::class,
        MakeArtisanCommand::class,
        MakeCastCommand::class,
        MakeChannelCommand::class,
        MakeComponentCommand::class,
        MakeDTOCommand::class,
        MakeEnumCommand::class,
        MakeEventCommand::class,
        MakeExceptionCommand::class,
        MakeFacadeCommand::class,
        MakeInterfaceCommand::class,
        MakeJobCommand::class,
        MakeListenerCommand::class,
        MakeMailCommand::class,
        MakeMiddlewareCommand::class,
        MakeMigrationCommand::class,
        MakeModelCommand::class,
        MakeNotificationCommand::class,
        MakeObserverCommand::class,
        MakePipelineCommand::class,
        MakePolicyCommand::class,
        MakeProviderCommand::class,
        MakeFactoryCommand::class,
        MakeRepositoryCommand::class,
        MakeRequestCommand::class,
        MakeResourceCommand::class,
        MakeRuleCommand::class,
        MakeScopeCommand::class,
        MakeSeederCommand::class,
        MakeServiceCommand::class,
        MakeTraitCommand::class,
        MakeViewCommand::class,
        BuildCommand::class,
        InspectCommand::class,
    ];

    $reflection = new ReflectionClass(Kernel::class);
    $property = $reflection->getProperty('commands');

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
    $commands = $property->getValue($kernel);

    expect($commands)->toContain(MakeActionCommand::class);
    expect($commands)->toContain(MakeServiceCommand::class);
});

test('bootstrap adds all commands to application', function () {
    $app = Application::create();
    $kernel = new Kernel($app);

    $reflection = new ReflectionClass(Kernel::class);
    $bootstrapMethod = $reflection->getMethod('bootstrap');
    $bootstrapMethod->invoke($kernel);

    expect($app->has('make:action'))->toBeTrue();
    expect($app->has('make:cast'))->toBeTrue();
    expect($app->has('make:channel'))->toBeTrue();
    expect($app->has('make:command'))->toBeTrue();
    expect($app->has('make:component'))->toBeTrue();
    expect($app->has('make:dto'))->toBeTrue();
    expect($app->has('make:enum'))->toBeTrue();
    expect($app->has('make:event'))->toBeTrue();
    expect($app->has('make:exception'))->toBeTrue();
    expect($app->has('make:facade'))->toBeTrue();
    expect($app->has('make:interface'))->toBeTrue();
    expect($app->has('make:job'))->toBeTrue();
    expect($app->has('make:listener'))->toBeTrue();
    expect($app->has('make:mail'))->toBeTrue();
    expect($app->has('make:middleware'))->toBeTrue();
    expect($app->has('make:migration'))->toBeTrue();
    expect($app->has('make:model'))->toBeTrue();
    expect($app->has('make:notification'))->toBeTrue();
    expect($app->has('make:observer'))->toBeTrue();
    expect($app->has('make:pipeline'))->toBeTrue();
    expect($app->has('make:policy'))->toBeTrue();
    expect($app->has('make:provider'))->toBeTrue();
    expect($app->has('make:factory'))->toBeTrue();
    expect($app->has('make:repository'))->toBeTrue();
    expect($app->has('make:request'))->toBeTrue();
    expect($app->has('make:resource'))->toBeTrue();
    expect($app->has('make:rule'))->toBeTrue();
    expect($app->has('make:scope'))->toBeTrue();
    expect($app->has('make:seeder'))->toBeTrue();
    expect($app->has('make:service'))->toBeTrue();
    expect($app->has('make:trait'))->toBeTrue();
    expect($app->has('make:view'))->toBeTrue();
    expect($app->has('app:build'))->toBeTrue();
    expect($app->has('app:inspect'))->toBeTrue();
});
