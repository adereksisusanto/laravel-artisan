<?php

use Adereksisusanto\Laravel\Artisan\Commands\BuildCommand;
use Illuminate\Filesystem\Filesystem;

test('build command is registered', function () {
    $this->artisan('list')
        ->assertSuccessful()
        ->expectsOutputToContain('app:build');
});

test('build stub method generates valid PHAR stub', function () {
    $command = new BuildCommand(app(Filesystem::class));

    $reflection = new ReflectionMethod($command, 'buildStub');
    $stub = $reflection->invoke($command, 'testapp');

    expect($stub)->toContain('#!/usr/bin/env php');
    expect($stub)->toContain('Phar::mapPhar');
    expect($stub)->toContain('__HALT_COMPILER();');
    expect($stub)->toContain("'testapp'");
});
