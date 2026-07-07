<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

class MakeFactoryCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:factory {name} {--model= : The model that the factory applies to} {--force : Create the class even if the factory already exists}';

    protected $description = 'Generate a new model factory class';

    protected function getStubName(): string
    {
        return 'factory.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Database/Factories';
    }

    protected function getPath(string $name): string
    {
        $custom = $this->getCustomDirectory();

        if ($custom) {
            return parent::getPath($name);
        }

        return database_path('factories/'.$name.'.php');
    }

    protected function getGeneratorKey(): ?string
    {
        return 'factory';
    }

    protected function buildClass(string $name): string
    {
        $stub = parent::buildClass($name);

        $model = $this->option('model') ?: $name;
        $modelNamespace = $this->resolveModelNamespace($model);

        $modelClassName = $this->getClassName($model);

        $replace = [
            '{{ modelNamespace }}' => $modelNamespace,
            '{{ model }}' => $modelClassName,
        ];

        return str_replace(array_keys($replace), array_values($replace), $stub);
    }

    protected function resolveModelNamespace(string $model): string
    {
        $composer = $this->getComposerConfig();
        $psr4 = $composer['autoload']['psr-4'] ?? [];
        $root = array_key_first($psr4);

        if ($root) {
            $root = rtrim($root, '\\');
        }

        $root = $root ?: 'App';

        $config = $composer['extra']['laravel-artisan']['paths']['model'] ?? null;
        $modelDir = $config ?: 'Models';

        $modelClassName = $this->getClassName($model);
        $subNamespace = $this->getSubNamespace($model);

        return '\\'.$root.'\\'.$modelDir.($subNamespace ? '\\'.$subNamespace : '').'\\'.$modelClassName;
    }
}
