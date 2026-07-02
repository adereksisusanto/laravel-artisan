<?php

namespace Adereksisusanto\Laravel\Artisan\Tests;

use Adereksisusanto\Laravel\Artisan\Providers\ArtisanServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            ArtisanServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('laravel-artisan.namespace', 'App');
        $app['config']->set('laravel-artisan.stubs_path', null);
    }
}
