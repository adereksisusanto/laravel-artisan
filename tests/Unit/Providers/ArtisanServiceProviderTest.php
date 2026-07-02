<?php

use Adereksisusanto\Laravel\Artisan\Providers\ArtisanServiceProvider;
use Illuminate\Contracts\Console\Kernel;

test('service provider registers all commands', function () {
    $kernel = $this->app->make(Kernel::class);
    $commandNames = [];
    foreach ($kernel->all() as $command) {
        $commandNames[] = $command->getName();
    }

    $expected = [
        'make:action',
        'make:cast',
        'make:channel',
        'make:command',
        'make:component',
        'make:dto',
        'make:enum',
        'make:event',
        'make:exception',
        'make:facade',
        'make:interface',
        'make:job',
        'make:listener',
        'make:mail',
        'make:middleware',
        'make:migration',
        'make:model',
        'make:notification',
        'make:observer',
        'make:pipeline',
        'make:policy',
        'make:provider',
        'make:factory',
        'make:repository',
        'make:request',
        'make:resource',
        'make:rule',
        'make:scope',
        'make:seeder',
        'make:service',
        'make:trait',
        'make:view',
        'app:build',
        'app:inspect',
    ];

    foreach ($expected as $command) {
        expect($commandNames)->toContain($command);
    }
});

test('config is merged', function () {
    expect(config('laravel-artisan.namespace'))->toBe('App');
    expect(config('laravel-artisan.stubs_path'))->toBeNull();
});

test('provider can be resolved', function () {
    $provider = $this->app->getProvider(ArtisanServiceProvider::class);

    expect($provider)->not->toBeNull();
});
