<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

abstract class BaseGeneratorCommand extends Command
{
    protected Filesystem $files;

    private ?array $composerConfig = null;

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

    protected function getGeneratorKey(): ?string
    {
        return null;
    }

    protected function getCustomDirectory(): ?string
    {
        $key = $this->getGeneratorKey();
        if (! $key) {
            return null;
        }

        $config = $this->getComposerConfig();

        return $config['extra']['laravel-artisan']['paths'][$key] ?? null;
    }

    protected function getStubPath(): string
    {
        $custom = base_path('stubs/vendor/laravel-artisan/'.$this->getStubName());
        if ($this->files()->exists($custom)) {
            return $custom;
        }

        return __DIR__.'/../Stubs/'.$this->getStubName();
    }

    protected function getComposerConfig(): array
    {
        if ($this->composerConfig === null) {
            $path = base_path('composer.json');
            $this->composerConfig = $this->files()->exists($path)
                ? json_decode($this->files()->get($path), true) ?? []
                : [];
        }

        return $this->composerConfig;
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

        $directory = $this->getCustomDirectory() ?? $this->getDefaultDirectory();

        return $root.'\\'.str_replace('/', '\\', $directory);
    }

    protected function getPath(string $name): string
    {
        $composer = $this->getComposerConfig();
        $psr4 = $composer['autoload']['psr-4'] ?? [];
        $dir = $psr4 ? rtrim((string) array_values($psr4)[0], '/') : 'app';

        $directory = $this->getCustomDirectory() ?? $this->getDefaultDirectory();

        return base_path($dir.'/'.$directory.'/'.$name.'.php');
    }

    protected function buildClass(string $name): string
    {
        $stub = $this->files()->get($this->getStubPath());

        $replace = array_merge([
            '{{ namespace }}' => $this->getNamespace(),
            '{{ class }}' => $name,
            '{{ classLower }}' => lcfirst($name),
            '{{ classSnake }}' => Str::snake($name),
            '{{ classKebab }}' => Str::kebab($name),
            '{{ classPlural }}' => Str::plural($name),
            '{{ classPluralLower }}' => lcfirst(Str::plural($name)),
        ], $this->getReplacements($name));

        return str_replace(array_keys($replace), array_values($replace), $stub);
    }

    protected function getReplacements(string $name): array
    {
        return [];
    }

    protected function generate(string $name, bool $force = false): bool
    {
        $path = $this->getPath($name);

        if (! $force && $this->files()->exists($path)) {
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
        $force = $this->option('force');

        if ($this->generate($name, $force)) {
            return self::SUCCESS;
        }

        return self::FAILURE;
    }
}
