<?php

use Adereksisusanto\Laravel\Artisan\Application;
use Adereksisusanto\Laravel\Artisan\Commands\MakeActionCommand;
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
    expect($app->getVersion())->not->toBeEmpty();
});

test('container has self reference', function () {
    $app = Application::create();

    expect($app->getContainer()->make(Application::class))->toBe($app);
});

test('registerServiceProviders registers multiple providers', function () {
    $app = Application::create();
    $container = $app->getContainer();

    $providerA = new class($container)
    {
        public function __construct(protected Container $container) {}

        public function register(): void
        {
            $this->container->instance('provider_a', 'registered');
        }
    };

    $providerB = new class($container)
    {
        public function __construct(protected Container $container) {}

        public function register(): void
        {
            $this->container->instance('provider_b', 'registered');
        }
    };

    $app->registerServiceProviders([$providerA::class, $providerB::class]);
    $app->boot();

    expect($container->make('provider_a'))->toBe('registered');
    expect($container->make('provider_b'))->toBe('registered');
});

test('boot calls provider boot method', function () {
    $app = Application::create();
    $container = $app->getContainer();

    $provider = new class($container)
    {
        public function __construct(protected Container $container) {}

        public function register(): void {}

        public function boot(): void
        {
            $this->container->instance('provider_booted', true);
        }
    };

    $app->registerServiceProvider($provider::class);
    $app->boot();

    expect($container->make('provider_booted'))->toBeTrue();
});

test('resolveCommands resolves class strings', function () {
    $app = Application::create();

    $app->resolveCommands(MakeServiceCommand::class);

    expect($app->has('make:service'))->toBeTrue();
});

test('resolveCommands resolves multiple commands', function () {
    $app = Application::create();

    $app->resolveCommands([
        MakeServiceCommand::class,
        MakeActionCommand::class,
    ]);

    expect($app->has('make:service'))->toBeTrue();
    expect($app->has('make:action'))->toBeTrue();
});

test('resolveCommands handles command instances', function () {
    $app = Application::create();
    $command = new class extends Command
    {
        public function configure(): void
        {
            $this->setName('app:custom');
        }

        public function execute(InputInterface $input, OutputInterface $output): int
        {
            return self::SUCCESS;
        }
    };

    $app->resolveCommands([$command]);

    expect($app->has('app:custom'))->toBeTrue();
});

test('bootstrappers registered during provider register are fired', function () {
    $app = Application::create();

    $provider = new class($app)
    {
        public function __construct(protected $app) {}

        public function register(): void
        {
            Illuminate\Console\Application::starting(function ($artisan) {
                $artisan->add(new class extends Command
                {
                    public function configure(): void
                    {
                        $this->setName('app:from-bootstrapper');
                    }

                    public function execute(InputInterface $i, OutputInterface $o): int
                    {
                        return self::SUCCESS;
                    }
                });
            });
        }
    };

    $app->registerServiceProvider($provider::class);
    $app->boot();

    expect($app->has('app:from-bootstrapper'))->toBeTrue();
});
