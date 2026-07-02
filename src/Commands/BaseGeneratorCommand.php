<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

abstract class BaseGeneratorCommand extends Command
{
    protected Filesystem $files;

    public function setFilesystem(Filesystem $files): void
    {
        $this->files = $files;
    }

    protected function files(): Filesystem
    {
        if (! isset($this->files)) {
            $this->files = app(Filesystem::class);
        }

        return $this->files;
    }

    abstract protected function getStubName(): string;

    abstract protected function getDefaultDirectory(): string;

    protected function getStubPath(): string
    {
        $configPath = config('laravel-artisan.stubs_path');

        if ($configPath && $this->files()->exists($configPath.'/'.$this->getStubName())) {
            return $configPath.'/'.$this->getStubName();
        }

        return __DIR__.'/../Stubs/'.$this->getStubName();
    }

    protected function getNamespace(): string
    {
        $root = config('laravel-artisan.namespace', 'App');

        return $root.'\\'.str_replace('/', '\\', $this->getDefaultDirectory());
    }

    protected function getPath(string $name): string
    {
        return app_path($this->getDefaultDirectory().'/'.$name.'.php');
    }

    protected function buildClass(string $name): string
    {
        $stub = $this->files()->get($this->getStubPath());

        $replace = [
            '{{ namespace }}' => $this->getNamespace(),
            '{{ class }}' => $name,
            '{{ classLower }}' => lcfirst($name),
            '{{ classSnake }}' => Str::snake($name),
            '{{ classKebab }}' => Str::kebab($name),
            '{{ classPlural }}' => Str::plural($name),
            '{{ classPluralLower }}' => lcfirst(Str::plural($name)),
        ];

        return str_replace(array_keys($replace), array_values($replace), $stub);
    }

    protected function generate(string $name): bool
    {
        $path = $this->getPath($name);

        if ($this->files()->exists($path)) {
            $this->error("{$name} already exists at {$path}!");

            return false;
        }

        $this->files()->ensureDirectoryExists(dirname($path));
        $this->files()->put($path, $this->buildClass($name));

        $relativePath = str_replace(base_path().'/', '', $path);
        $this->info("{$name} created successfully at {$relativePath}.");

        return true;
    }

    public function handle(): int
    {
        $name = $this->argument('name');

        if ($this->generate($name)) {
            return self::SUCCESS;
        }

        return self::FAILURE;
    }
}
