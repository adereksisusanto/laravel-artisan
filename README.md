# Laravel Artisan

For Laravel package developers only – artisan commands to scaffold boilerplate code for your packages.

## Installation

```bash
composer require adereksisusanto/laravel-artisan --dev
```

## Quick Start (Standalone CLI)

Create `artisan` (or `myapp`) in your project root:

```php
#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

use Adereksisusanto\Laravel\Artisan\Application;
use Adereksisusanto\Laravel\Artisan\Kernel;

$app = Application::create(__DIR__);

$kernel = new Kernel($app);
$status = $kernel->handle();
$kernel->terminate($status);
```

Run it:

```bash
php artisan list
```

## Available Commands

| Command | Description |
|---------|-------------|
| `make:command <name>` | Generate a new artisan command |
| `make:service <name>` | Generate a service class |
| `make:repository <name>` | Generate a repository class |
| `make:dto <name>` | Generate a DTO class |
| `make:action <name>` | Generate an action class |
| `make:enum <name>` | Generate an enum class |
| `make:interface <name>` | Generate an interface |
| `make:trait <name>` | Generate a trait |
| `app:build <name>` | Build a PHAR archive |
| `app:inspect` | Inspect application details |

## Usage in Laravel

The service provider auto-registers all `make:*` commands. Publish config with:

```bash
php artisan vendor:publish --tag=laravel-artisan-config
php artisan vendor:publish --tag=laravel-artisan-stubs
```

## Registering Custom Commands

```php
use Adereksisusanto\Laravel\Artisan\Kernel;

$kernel = new Kernel($app);
$kernel->registerCommand(\App\Commands\MyCommand::class);
$kernel->handle();
```

## Build PHAR

```bash
php artisan app:build myapp
./myapp list
```
