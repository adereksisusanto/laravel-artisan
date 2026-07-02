<?php

use Adereksisusanto\Laravel\Artisan\Application;
use Adereksisusanto\Laravel\Artisan\Commands\MakeServiceCommand;
use Illuminate\Container\Container;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

test('can be created statically', function () {
    $app = Application::create(__DIR__);

    expect($app)->toBeInstanceOf(Application::class);
    expect($app->getContainer())->toBeInstanceOf(Container::class);
});

test('sets base path', function () {
    $app = Application::create('/tmp/test-app');

    expect($app->getBasePath())->toBe('/tmp/test-app');
    expect($app->getContainer()->make('path'))->toBe('/tmp/test-app/app');
    expect($app->getContainer()->make('path.base'))->toBe('/tmp/test-app');
    expect($app->getContainer()->make('path.config'))->toBe('/tmp/test-app/config');
    expect($app->getContainer()->make('path.storage'))->toBe('/tmp/test-app/storage');
});

test('registers filesystem in container', function () {
    $app = Application::create();

    expect($app->getContainer()->has('files'))->toBeTrue();
});

test('injects filesystem into generator commands', function () {
    $app = Application::create();
    $command = new MakeServiceCommand;

    $app->add($command);

    expect($app->has('make:service'))->toBeTrue();
});

test('does not inject filesystem for regular commands', function () {
    $app = Application::create();
    $command = new class extends Command
    {
        protected static $defaultName = 'app:test-command';

        public function configure(): void
        {
            $this->setName('app:test-command');
        }

        public function execute(InputInterface $input, OutputInterface $output): int
        {
            return self::SUCCESS;
        }
    };

    $app->add($command);

    expect($app->has('app:test-command'))->toBeTrue();
});

test('boot runs registered providers', function () {
    $app = Application::create();
    $container = $app->getContainer();

    $provider = new class($container)
    {
        public function __construct(protected Container $container) {}

        public function register(): void
        {
            $this->container->instance('provider_registered', true);
        }
    };

    $app->registerServiceProvider($provider::class);
    $app->boot();

    expect($container->make('provider_registered'))->toBeTrue();
});

test('boot is idempotent', function () {
    $app = Application::create();
    $container = $app->getContainer();

    $provider = new class($container)
    {
        public function __construct(protected Container $container) {}

        public function register(): void
        {
            $count = $this->container->has('boot_count') ? $this->container->make('boot_count') : 0;
            $this->container->instance('boot_count', $count + 1);
        }
    };

    $app->registerServiceProvider($provider::class);
    $app->boot();
    $app->boot();

    expect($container->make('boot_count'))->toBe(1);
});

test('has correct name and version', function () {
    $app = Application::create();

    expect($app->getName())->toBe('Laravel Artisan');
    expect($app->getVersion())->toBe('1.0.0');
});

test('container has self reference', function () {
    $app = Application::create();

    expect($app->getContainer()->make(Application::class))->toBe($app);
});
