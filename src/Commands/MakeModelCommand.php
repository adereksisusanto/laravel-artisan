<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

use Illuminate\Support\Str;

class MakeModelCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:model {name} {--all : Generate a migration, seeder, factory, policy, resource controller, and form requests} {--controller : Create a new controller for the model} {--factory : Create a new factory for the model} {--force : Create the class even if the model already exists} {--migration : Create a new migration file} {--policy : Create a new policy for the model} {--seed : Create a new seeder for the model} {--resource : Indicates if the generated controller should be a resource controller} {--api : Indicates if the generated controller should be an API resource controller} {--requests : Create new form request classes and use them in the resource controller}';

    protected $description = 'Generate a new Eloquent model class';

    protected function getStubName(): string
    {
        return 'model.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Models';
    }

    protected function getGeneratorKey(): ?string
    {
        return 'model';
    }

    public function handle(): int
    {
        $name = $this->argument('name');
        $force = $this->option('force');
        $all = $this->option('all');

        if (! $this->generate($name, $force)) {
            return self::FAILURE;
        }

        $table = Str::snake(Str::pluralStudly($name));

        if ($all || $this->option('migration')) {
            $migrationName = 'create_'.$table.'_table';
            $this->call('make:migration', ['name' => $migrationName]);
        }

        if ($all || $this->option('factory')) {
            $this->call('make:factory', ['name' => $name]);
        }

        if ($all || $this->option('seed')) {
            $this->call('make:seeder', ['name' => $name.'Seeder']);
        }

        if ($all || $this->option('policy')) {
            $this->call('make:policy', ['name' => $name.'Policy']);
        }

        if ($all || $this->option('controller')) {
            $controllerOptions = ['name' => $name.'Controller'];

            if ($all || $this->option('resource')) {
                $controllerOptions['--resource'] = true;
            }

            if ($this->option('api')) {
                $controllerOptions['--api'] = true;
            }

            if ($all || $this->option('requests')) {
                $controllerOptions['--requests'] = true;
            }

            $this->call('make:controller', $controllerOptions);
        }

        if ($all || $this->option('requests')) {
            $this->call('make:request', ['name' => 'Store'.$name.'Request']);
            $this->call('make:request', ['name' => 'Update'.$name.'Request']);
        }

        return self::SUCCESS;
    }
}
