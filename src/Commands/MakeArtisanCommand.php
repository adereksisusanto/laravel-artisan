<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

use Illuminate\Support\Str;

class MakeArtisanCommand extends BaseGeneratorCommand
{
    protected $signature = 'make:command {name} {--command= : The terminal command name} {--force : Create the class even if the command already exists}';

    protected $description = 'Generate a new artisan command class';

    protected function getStubName(): string
    {
        return 'command.stub';
    }

    protected function getDefaultDirectory(): string
    {
        return 'Commands';
    }

    protected function getGeneratorKey(): ?string
    {
        return 'command';
    }

    protected function buildClass(string $name): string
    {
        $stub = $this->files()->get($this->getStubPath());

        $className = $this->getClassName($name);
        $subNamespace = $this->getSubNamespace($name);
        $namespace = $this->getNamespace().($subNamespace ? '\\'.$subNamespace : '');

        $command = $this->option('command') ?: 'app:'.Str::kebab($className);
        $replace = [
            '{{ commandSignature }}' => $command,
        ];

        $stub = str_replace(array_keys($replace), array_values($replace), $stub);

        $classReplace = [
            '{{ namespace }}' => $namespace,
            '{{ class }}' => $className,
            '{{ classLower }}' => lcfirst($className),
            '{{ classSnake }}' => Str::snake($className),
            '{{ classKebab }}' => Str::kebab($className),
            '{{ classPlural }}' => Str::plural($className),
            '{{ classPluralLower }}' => lcfirst(Str::plural($className)),
        ];

        return str_replace(array_keys($classReplace), array_values($classReplace), $stub);
    }
}
