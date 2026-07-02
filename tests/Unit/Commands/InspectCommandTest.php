<?php

test('inspect displays application info', function () {
    $this->artisan('app:inspect')
        ->assertSuccessful()
        ->expectsOutputToContain('PHP Version:')
        ->expectsOutputToContain('Application Path:')
        ->expectsOutputToContain('Environment:')
        ->expectsOutputToContain('Config Path:')
        ->expectsOutputToContain('Registered Commands:');
});

test('inspect command is registered', function () {
    $this->artisan('list')
        ->assertSuccessful()
        ->expectsOutputToContain('app:inspect');
});
