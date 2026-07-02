<?php

namespace Adereksisusanto\Laravel\Artisan\Providers;

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
use Illuminate\Support\ServiceProvider;

class ArtisanServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/app.php', 'laravel-artisan');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
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
            ]);
        }

        $this->publishes([
            __DIR__.'/../../config/app.php' => config_path('laravel-artisan.php'),
        ], 'laravel-artisan-config');

        $this->publishes([
            __DIR__.'/../Stubs' => base_path('stubs/laravel-artisan'),
        ], 'laravel-artisan-stubs');
    }
}
