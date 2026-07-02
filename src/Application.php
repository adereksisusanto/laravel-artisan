<?php

namespace Adereksisusanto\Laravel\Artisan;

use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Application as SymfonyApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Application extends SymfonyApplication
{
    protected Container $container;

    protected array $serviceProviders = [];

    protected ?string $basePath = null;

    protected bool $booted = false;

    public function __construct(?Container $container = null)
    {
        parent::__construct('Laravel Artisan', '1.0.0');

        $this->container = $container ?: new Container;
        $this->container->instance(self::class, $this);
        $this->container->instance(SymfonyApplication::class, $this);
    }

    public function setBasePath(string $path): static
    {
        $this->basePath = $path;

        $this->container->instance('path', $path.'/app');
        $this->container->instance('path.base', $path);
        $this->container->instance('path.config', $path.'/config');
        $this->container->instance('path.storage', $path.'/storage');

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

    public function boot(): void
    {
        if ($this->booted) {
            return;
        }

        foreach ($this->serviceProviders as $provider) {
            $instance = new $provider($this->container);
            $instance->register();
        }

        $this->booted = true;
    }

    public function getContainer(): Container
    {
        return $this->container;
    }

    public function add(Command $command): ?Command
    {
        return $this->addCommand($command);
    }

    public function addCommand(callable|Command $command): ?Command
    {
        if ($command instanceof Commands\BaseGeneratorCommand) {
            $command->setFilesystem($this->container->make('files'));
        }

        return parent::addCommand($command);
    }

    protected function doRunCommand(Command $command, InputInterface $input, OutputInterface $output): int
    {
        $this->boot();

        return parent::doRunCommand($command, $input, $output);
    }

    public static function create(?string $basePath = null): self
    {
        $container = new Container;

        $container->singleton('files', function () {
            return new Filesystem;
        });

        $app = new self($container);

        if ($basePath) {
            $app->setBasePath($basePath);
        }

        return $app;
    }
}
