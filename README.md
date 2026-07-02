# Laravel Artisan

[![Tests](https://img.shields.io/badge/tests-86%20passing-brightgreen?style=flat-square)](https://github.com/adereksisusanto/laravel-artisan)
[![PHPStan](https://img.shields.io/badge/PHPStan-level%205-brightgreen?style=flat-square)](https://github.com/adereksisusanto/laravel-artisan)
[![Packagist Version](https://img.shields.io/packagist/v/adereksisusanto/laravel-artisan?style=flat-square)](https://packagist.org/packages/adereksisusanto/laravel-artisan)
[![Packagist Downloads](https://img.shields.io/packagist/dt/adereksisusanto/laravel-artisan?style=flat-square)](https://packagist.org/packages/adereksisusanto/laravel-artisan)
[![PHP Version](https://img.shields.io/badge/php-%5E8.3%7C%5E8.5-777bb3?style=flat-square)](https://github.com/adereksisusanto/laravel-artisan)
[![License](https://img.shields.io/badge/license-MIT-blue?style=flat-square)](https://github.com/adereksisusanto/laravel-artisan)

Artisan commands to scaffold boilerplate code — designed for Laravel package developers.

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
| `make:action <name>` | Generate an action class |
| `make:cast <name>` | Generate a custom Eloquent cast class |
| `make:channel <name>` | Generate a broadcast channel class |
| `make:command <name>` | Generate a new artisan command |
| `make:component <name>` | Generate a view component class |
| `make:dto <name>` | Generate a DTO class |
| `make:enum <name>` | Generate an enum class |
| `make:event <name>` | Generate an event class |
| `make:exception <name>` | Generate an exception class |
| `make:facade <name>` | Generate a facade class |
| `make:interface <name>` | Generate an interface |
| `make:factory <name>` | Generate a model factory class |
| `make:job <name>` | Generate a queued job class |
| `make:listener <name>` | Generate an event listener class |
| `make:mail <name>` | Generate a mailable class |
| `make:middleware <name>` | Generate a middleware class |
| `make:migration <name>` | Generate a migration file |
| `make:model <name>` | Generate an Eloquent model class |
| `make:notification <name>` | Generate a notification class |
| `make:observer <name>` | Generate an observer class |
| `make:pipeline <name>` | Generate a pipeline class |
| `make:policy <name>` | Generate a policy class |
| `make:provider <name>` | Generate a service provider class |
| `make:repository <name>` | Generate a repository class |
| `make:request <name>` | Generate a form request class |
| `make:resource <name>` | Generate an API resource class |
| `make:rule <name>` | Generate a validation rule class |
| `make:scope <name>` | Generate a query scope class |
| `make:seeder <name>` | Generate a seeder class |
| `make:service <name>` | Generate a service class |
| `make:trait <name>` | Generate a trait |
| `make:view <name>` | Generate a Blade view file |
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

## Contributing

1. **Fork & clone**
   ```bash
   git clone https://github.com/<your-username>/laravel-artisan.git
   cd laravel-artisan
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Create a branch**
   ```bash
   git checkout -b feat/your-feature-name
   ```

4. **Make changes & run quality checks**
   ```bash
   composer check
   ```
   This runs Pint (style), PHPStan (static analysis), and Pest (tests).

5. **Run tests for all supported Laravel versions** (optional, requires Docker)
   ```bash
   # Test against Laravel 11
   composer require laravel/framework:^11.0 orchestra/testbench:^9.0 --no-update --dev && composer update --prefer-stable && composer test

   # Test against Laravel 12
   composer require laravel/framework:^12.0 orchestra/testbench:^10.0 --no-update --dev && composer update --prefer-stable && composer test

   # Test against Laravel 13
   composer require laravel/framework:^13.0 orchestra/testbench:^11.0 --no-update --dev && composer update --prefer-stable && composer test
   ```

6. **Commit & push**
   ```bash
   git add .
   git commit -m "feat: add your feature"
   git push origin feat/your-feature-name
   ```

7. **Open a pull request** on [GitHub](https://github.com/adereksisusanto/laravel-artisan)

## Contributors

[![All Contributors](https://img.shields.io/github/all-contributors/adereksisusanto/laravel-artisan?style=flat-square)](#contributors)

Thanks goes to these wonderful people:

<!-- ALL-CONTRIBUTORS-LIST:START -->
<!-- prettier-ignore-start -->
<!-- markdownlint-disable -->
<table>
  <tbody>
    <tr>
      <td align="center" valign="top" width="14.28%"><a href="https://github.com/adereksisusanto"><img src="https://avatars.githubusercontent.com/u/38015761?v=4" width="64px;" alt="Ade Reksi Susanto"/><br /><sub><b>Ade Reksi Susanto</b></sub></a></td>
    </tr>
  </tbody>
</table>
<!-- markdownlint-restore -->
<!-- prettier-ignore-end -->
<!-- ALL-CONTRIBUTORS-LIST:END -->

Contributions are welcome! Please open an issue or pull request.
