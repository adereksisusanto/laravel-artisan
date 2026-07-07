<?php

namespace Adereksisusanto\Laravel\Artisan;

use Composer\InstalledVersions;
use Illuminate\Console\Command as IlluminateCommand;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Application as SymfonyApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Application extends SymfonyApplication
{
    protected LaravelApplication $container;

    protected array $serviceProviders = [];

    protected ?string $basePath = null;

    protected bool $booted = false;

    public function __construct(?LaravelApplication $container = null)
    {
        parent::__construct(
            'Laravel Artisan',
            $this->getInstalledVersion(),
        );

        $this->container = $container ?: new LaravelApplication;
        $this->container->instance(self::class, $this);
        $this->container->instance(SymfonyApplication::class, $this);
    }

    protected function getInstalledVersion(): string
    {
        try {
            return InstalledVersions::getPrettyVersion('adereksisusanto/laravel-artisan')
                ?? '1.0.0';
        } catch (\OutOfBoundsException) {
            return '1.0.0';
        }
    }

    public function setBasePath(string $path): static
    {
        $this->basePath = $path;
        $this->container->setBasePath($path);

        return $this;
    }

    public function getBasePath(): ?string
    {
        return $this->basePath;
    }

    public function registerServiceProvider(string $provider): void
    {
        $this->serviceProviders[] = $provider;
    }

    public function registerServiceProviders(array $providers): void
    {
        $this->serviceProviders = array_merge($this->serviceProviders, $providers);
    }

    public function boot(): void
    {
        if ($this->booted) {
            return;
        }

        $this->clearBootstrappers();

        foreach ($this->serviceProviders as $provider) {
            $instance = new $provider($this->container);
            $instance->register();
        }

        $this->fireStartingBootstrappers();

        foreach ($this->serviceProviders as $provider) {
            $instance = new $provider($this->container);
            if (method_exists($instance, 'boot')) {
                $instance->boot();
            }
        }

        $this->booted = true;
    }

    public function resolveCommands(array|string $commands): static
    {
        $commands = is_array($commands) ? $commands : func_get_args();

        foreach ($commands as $command) {
            if ($command instanceof Command) {
                $this->add($command);
            } else {
                $this->add($this->container->make($command));
            }
        }

        return $this;
    }

    protected function clearBootstrappers(): void
    {
        $reflection = new \ReflectionClass(\Illuminate\Console\Application::class);
        $property = $reflection->getProperty('bootstrappers');
        $property->setValue([]);
    }

    protected function fireStartingBootstrappers(): void
    {
        $reflection = new \ReflectionClass(\Illuminate\Console\Application::class);
        $property = $reflection->getProperty('bootstrappers');
        $bootstrappers = $property->getValue();

        foreach ($bootstrappers as $bootstrapper) {
            $bootstrapper($this);
        }
    }

    public function getContainer(): LaravelApplication
    {
        return $this->container;
    }

    public function add(Command $command): ?Command
    {
        if ($command instanceof IlluminateCommand) {
            $command->setLaravel($this->container);
        }

        if ($command instanceof Commands\BaseGeneratorCommand) {
            $command->setFilesystem($this->container->make('files'));
        }

        try {
            return (new \ReflectionClass(parent::class))->getMethod('add')->invoke($this, $command);
        } catch (\ReflectionException) {
            return (new \ReflectionClass(parent::class))->getMethod('addCommand')->invoke($this, $command);
        }
    }

    protected function doRunCommand(Command $command, InputInterface $input, OutputInterface $output): int
    {
        $this->boot();

        return parent::doRunCommand($command, $input, $output);
    }

    public static function create(?string $basePath = null): self
    {
        $container = new LaravelApplication;

        $container->singleton('files', function () {
            return new Filesystem;
        });

        $app = new self($container);

        if ($basePath) {
            $app->setBasePath($basePath);
        }

        $container->instance(LaravelApplication::class, $container);
        Container::setInstance($container);

        return $app;
    }
}
