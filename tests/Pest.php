<?php

use Adereksisusanto\Laravel\Artisan\Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Pest Configuration
|--------------------------------------------------------------------------
*/

uses(TestCase::class)
    ->beforeEach(function () {
        $this->app['config']->set('laravel-artisan.namespace', 'App');
        $this->app['config']->set('laravel-artisan.stubs_path', null);
    })
    ->in('Unit');

expect()->extend('toBeSuccess', function () {
    return $this->toEqual(0);
});
