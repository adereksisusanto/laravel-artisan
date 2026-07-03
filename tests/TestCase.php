<?php

namespace Adereksisusanto\Laravel\Artisan\Tests;

use Adereksisusanto\Laravel\Artisan\Commands\BuildCommand;
use Adereksisusanto\Laravel\Artisan\Commands\InspectCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeActionCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeArtisanCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeCastCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeChannelCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeComponentCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeConfigCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeControllerCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeDTOCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeEnumCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeEventCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeExceptionCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeFacadeCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeFactoryCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeInterfaceCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeJobCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeLanguageCommand;
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
use Adereksisusanto\Laravel\Artisan\Commands\MakeRoutesCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeRuleCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeScopeCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeSeederCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeServiceCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeTraitCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeViewCommand;
use Adereksisusanto\Laravel\Artisan\Commands\StubsPublishCommand;
use Illuminate\Support\ServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            TestServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('laravel-artisan.namespace', 'App');
        $app['config']->set('laravel-artisan.stubs_path', null);
    }
}

class TestServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeActionCommand::class,
                MakeArtisanCommand::class,
                MakeCastCommand::class,
                MakeChannelCommand::class,
                MakeComponentCommand::class,
                MakeConfigCommand::class,
                MakeControllerCommand::class,
                MakeDTOCommand::class,
                MakeEnumCommand::class,
                MakeEventCommand::class,
                MakeExceptionCommand::class,
                MakeFacadeCommand::class,
                MakeInterfaceCommand::class,
                MakeJobCommand::class,
                MakeLanguageCommand::class,
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
                MakeRoutesCommand::class,
                MakeResourceCommand::class,
                MakeRuleCommand::class,
                MakeScopeCommand::class,
                MakeSeederCommand::class,
                MakeServiceCommand::class,
                MakeTraitCommand::class,
                MakeViewCommand::class,
                BuildCommand::class,
                InspectCommand::class,
                StubsPublishCommand::class,
            ]);
        }
    }
}
