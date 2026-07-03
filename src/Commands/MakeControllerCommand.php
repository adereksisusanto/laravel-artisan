<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeControllerCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:controller {name} {--invokable : Generate a single action, invokable controller class} {--model= : Generate a resource controller with the given model name} {--resource : Generate a resource controller} {--api : Exclude the create and edit methods from the controller} {--requests : Generate form request classes} {--force : Create the class even if the controller already exists}';

    protected $description = 'Generate a new controller class';

    protected function getStubName(): string
    {
        if ($this->option('invokable')) {
            return 'controller.invokable.stub';
        }

        if ($this->option('api')) {
            return 'controller.api.stub';
        }

        if ($this->option('resource') || $this->option('model')) {
            return 'controller.resource.stub';
        }

        return 'controller.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Http/Controllers';
    }

    protected function getGeneratorKey(): ?string
    {
        return 'controller';
    }

    public function handle(): int
    {
        $name = $this->argument('name');
        $force = $this->option('force');

        if (! $this->generate($name, $force)) {
            return self::FAILURE;
        }

        if ($this->option('requests') || $this->option('model')) {
            $model = $this->option('model') ?: str_replace('Controller', '', $name);

            $this->call('make:request', ['name' => 'Store'.$model.'Request']);
            $this->call('make:request', ['name' => 'Update'.$model.'Request']);
        }

        return self::SUCCESS;
    }
}
