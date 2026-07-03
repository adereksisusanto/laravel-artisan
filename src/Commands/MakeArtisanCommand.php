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

        $command = $this->option('command') ?: 'app:'.Str::kebab($name);
        $replace = [
            '{{ commandSignature }}' => $command,
        ];

        $stub = str_replace(array_keys($replace), array_values($replace), $stub);

        $classReplace = [
            '{{ namespace }}' => $this->getNamespace(),
            '{{ class }}' => $name,
            '{{ classLower }}' => lcfirst($name),
            '{{ classSnake }}' => Str::snake($name),
            '{{ classKebab }}' => Str::kebab($name),
            '{{ classPlural }}' => Str::plural($name),
            '{{ classPluralLower }}' => lcfirst(Str::plural($name)),
        ];

        return str_replace(array_keys($classReplace), array_values($classReplace), $stub);
    }
}
