<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MakeMigrationCommand extends Command
{
    protected $signature = 'make:migration {name}';

    protected $description = 'Generate a new migration file';

    public function handle(Filesystem $files): int
    {
        $name = $this->argument('name');
        $table = $this->guessTableName($name);
        $timestamp = date('Y_m_d_His');
        $filename = "{$timestamp}_{$name}.php";

        $stub = $files->get(__DIR__.'/../Stubs/migration.stub');
        $stub = str_replace('{{ table }}', $table, $stub);

        $path = database_path("migrations/{$filename}");

        if ($files->exists($path)) {
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
