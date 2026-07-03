<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MakeMigrationCommand extends Command
{
    protected $signature = 'make:migration {name} {--create= : The table to be created} {--table= : The table to migrate} {--path= : The location where the migration file should be created} {--force : Create the migration even if it already exists}';

    protected $description = 'Generate a new migration file';

    private ?array $composerConfig = null;

    protected function getComposerConfig(): array
    {
        if ($this->composerConfig === null) {
            $path = base_path('composer.json');
            $files = app(Filesystem::class);
            $this->composerConfig = $files->exists($path)
                ? json_decode($files->get($path), true) ?? []
                : [];
        }

        return $this->composerConfig;
    }

    protected function getCustomDirectory(): ?string
    {
        $config = $this->getComposerConfig();

        return $config['extra']['laravel-artisan']['paths']['migration'] ?? null;
    }

    public function handle(Filesystem $files): int
    {
        $name = $this->argument('name');
        $force = $this->option('force');
        $create = $this->option('create');
        $table = $this->option('table') ?: $this->guessTableName($name);
        $timestamp = date('Y_m_d_His');
        $filename = "{$timestamp}_{$name}.php";

        // When --create is specified, prepend create_ and append _table
        if ($create) {
            $table = $create;
            $filename = date('Y_m_d_His')."_create_{$create}_table.php";
        }

        $stub = $files->get(__DIR__.'/../Stubs/migration.stub');
        $stub = str_replace('{{ table }}', $table, $stub);

        $custom = $this->getCustomDirectory();

        if ($this->option('path')) {
            $path = base_path($this->option('path').'/'.$filename);
        } elseif ($custom) {
            $composer = $this->getComposerConfig();
            $psr4 = $composer['autoload']['psr-4'] ?? [];
            $dir = $psr4 ? rtrim((string) array_values($psr4)[0], '/') : 'app';
            $path = base_path($dir.'/'.$custom.'/'.$filename);
        } else {
            $path = database_path("migrations/{$filename}");
        }

        if (! $force && $files->exists($path)) {
            $this->error("Migration already exists at {$path}!");

            return self::FAILURE;
        }

        $files->ensureDirectoryExists(dirname($path));
        $files->put($path, $stub);

        $relativePath = str_replace(base_path().'/', '', $path);
        $this->info("Migration created successfully at {$relativePath}.");

        return self::SUCCESS;
    }

    protected function guessTableName(string $name): string
    {
        $name = Str::snake($name);
        $name = preg_replace('/^(create|update|delete|add|drop|alter|change|rename)_/', '', $name);
        $name = preg_replace('/_(table|to|on|in|for|column|columns|field|fields)_?/', '', $name);
        $name = preg_replace('/_table$/', '', $name);

        return Str::plural($name) ?: 'table';
    }
}
