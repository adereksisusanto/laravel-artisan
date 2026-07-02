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
        'make:command',
        'make:dto',
        'make:enum',
        'make:interface',
        'make:repository',
        'make:service',
        'make:trait',
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
