<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeViewCommand extends Command
{
    protected $signature = 'make:view {name} {--force : Create the view even if it already exists}';

    protected $description = 'Generate a new Blade view file';

    public function handle(Filesystem $files): int
    {
        $name = $this->argument('name');
        $force = $this->option('force');

        $stub = $files->get(__DIR__.'/../Stubs/view.stub');
        $stub = str_replace('{{ class }}', $name, $stub);

        $path = resource_path("views/{$name}.blade.php");

        if (! $force && $files->exists($path)) {
            $this->error("View already exists at {$path}!");

            return self::FAILURE;
        }

        $files->ensureDirectoryExists(dirname($path));
        $files->put($path, $stub);

        $relativePath = str_replace(base_path().'/', '', $path);
        $this->info("View created successfully at {$relativePath}.");

        return self::SUCCESS;
    }
}
