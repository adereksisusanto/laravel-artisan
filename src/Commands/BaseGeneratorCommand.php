<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

abstract class BaseGeneratorCommand extends Command
{
    protected Filesystem $files;

    protected static ?array $composerConfig = null;

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
        return __DIR__.'/../Stubs/'.$this->getStubName();
    }

    protected function getComposerConfig(): array
    {
        if (static::$composerConfig === null) {
            $path = base_path('composer.json');
            static::$composerConfig = $this->files()->exists($path)
                ? json_decode($this->files()->get($path), true) ?? []
                : [];
        }

        return static::$composerConfig;
    }

    protected function getNamespace(): string
    {
        $composer = $this->getComposerConfig();
        $psr4 = $composer['autoload']['psr-4'] ?? [];
        $root = array_key_first($psr4);

        if ($root) {
            $root = rtrim($root, '\\');
        }

        $root = $root ?: 'App';

        return $root.'\\'.str_replace('/', '\\', $this->getDefaultDirectory());
    }

    protected function getPath(string $name): string
    {
        $composer = $this->getComposerConfig();
        $psr4 = $composer['autoload']['psr-4'] ?? [];
        $dir = $psr4 ? rtrim((string) array_values($psr4)[0], '/') : 'app';

        return base_path($dir.'/'.$this->getDefaultDirectory().'/'.$name.'.php');
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
