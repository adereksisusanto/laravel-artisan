<?php

namespace Adereksisusanto\Laravel\Artisan;

use Illuminate\Container\Container;

class LaravelApplication extends Container
{
    protected ?string $basePath = null;

    public function runningUnitTests(): bool
    {
        return false;
    }

    public function setBasePath(string $basePath): void
    {
        $this->basePath = $basePath;
        $this->instance('path', $basePath.'/app');
        $this->instance('path.base', $basePath);
        $this->instance('path.config', $basePath.'/config');
        $this->instance('path.storage', $basePath.'/storage');
    }

    public function path(string $path = ''): string
    {
        return $this->make('path').($path ? '/'.$path : '');
    }

    public function basePath(string $path = ''): string
    {
        return ($this->basePath ?? $this->make('path.base')).($path ? '/'.$path : '');
    }

    public function configPath(string $path = ''): string
    {
        return $this->make('path.config').($path ? '/'.$path : '');
    }

    public function storagePath(string $path = ''): string
    {
        return $this->make('path.storage').($path ? '/'.$path : '');
    }

    public function resourcePath(string $path = ''): string
    {
        return $this->basePath.'/resources'.($path ? '/'.$path : '');
    }

    public function databasePath(string $path = ''): string
    {
        return $this->basePath.'/database'.($path ? '/'.$path : '');
    }
}
