# Laravel Artisan

[![Tests](https://img.shields.io/badge/tests-83%20passing-brightgreen?style=flat-square)](https://github.com/adereksisusanto/laravel-artisan)
[![PHPStan](https://img.shields.io/badge/PHPStan-level%205-brightgreen?style=flat-square)](https://github.com/adereksisusanto/laravel-artisan)
[![Packagist Version](https://img.shields.io/packagist/v/adereksisusanto/laravel-artisan?style=flat-square)](https://packagist.org/packages/adereksisusanto/laravel-artisan)
[![Packagist Downloads](https://img.shields.io/packagist/dt/adereksisusanto/laravel-artisan?style=flat-square)](https://packagist.org/packages/adereksisusanto/laravel-artisan)
[![PHP Version](https://img.shields.io/badge/php-%5E8.3%7C%5E8.5-777bb3?style=flat-square)](https://github.com/adereksisusanto/laravel-artisan)
[![License](https://img.shields.io/badge/license-MIT-blue?style=flat-square)](https://github.com/adereksisusanto/laravel-artisan)

Perintah Artisan untuk membuat kode boilerplate — dirancang untuk pengembang paket Laravel.

> **Catatan:** Paket ini berjalan secara **mandiri** — tidak terintegrasi dengan aplikasi Laravel. Cocok untuk pengembangan paket yang membutuhkan scaffolding artisan tanpa menjalankan aplikasi Laravel secara penuh.

**Bahasa:** Indonesia | [English](README.md)

## Instalasi

```bash
composer require adereksisusanto/laravel-artisan --dev
```

Setelah instalasi, titik masuk `bin/artisan` tersedia di direktori `vendor/bin` proyek Anda.

## Mulai Cepat

Buat file `artisan` di root proyek Anda (atau gunakan `vendor/bin/artisan` langsung):

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

Kemudian jalankan:

```bash
php artisan list
```

Namespace dan path sumber dibaca otomatis dari PSR-4 `composer.json` proyek Anda — tanpa perlu konfigurasi tambahan.

## Path Kustom

Anda dapat menimpa direktori output default untuk setiap generator melalui `composer.json`:

```json
{
    "extra": {
        "laravel-artisan": {
            "paths": {
                "model": "Models",
                "enum": "Enums",
                "interface": "Contracts",
                "factory": "Database/Factories",
                "migration": "Database/Migrations",
                "seeder": "Database/Seeders",
                "request": "Http/Requests",
                "middleware": "Http/Middleware",
                "resource": "Http/Resources",
                "component": "View/Components",
                "controller": "Http/Controllers",
                "action": "Actions",
                "service": "Services",
                "repository": "Repositories",
                "dto": "DTOs",
                "trait": "Traits",
                "job": "Jobs",
                "event": "Events",
                "listener": "Listeners",
                "mail": "Mail",
                "notification": "Notifications",
                "rule": "Rules",
                "scope": "Scopes",
                "observer": "Observers",
                "pipeline": "Pipelines",
                "policy": "Policies",
                "provider": "Providers",
                "facade": "Facades",
                "exception": "Exceptions",
                "cast": "Casts",
                "command": "Commands",
                "channel": "Broadcasting",
                "config": "config",
                "lang": "lang",
                "routes": "routes"
            }
        }
    }
}
```

Hanya atur key yang ingin dikustomisasi; lainnya akan menggunakan direktori default.

## Perintah yang Tersedia

| Perintah | Deskripsi |
|----------|-----------|
| `make:action <name>` | Membuat kelas action |
| `make:cast <name>` | Membuat kelas custom Eloquent cast |
| `make:channel <name>` | Membuat kelas broadcast channel |
| `make:command <name>` | Membuat perintah artisan baru |
| `make:component <name>` | Membuat kelas view component |
| `make:config <name>` | Membuat file konfigurasi |
| `make:controller <name>` | Membuat kelas controller |
| `make:dto <name>` | Membuat kelas DTO |
| `make:enum <name>` | Membuat kelas enum |
| `make:event <name>` | Membuat kelas event |
| `make:exception <name>` | Membuat kelas exception |
| `make:facade <name>` | Membuat kelas facade |
| `make:interface <name>` | Membuat interface |
| `make:factory <name>` | Membuat kelas model factory |
| `make:job <name>` | Membuat kelas queued job |
| `make:lang <name>` | Membuat file bahasa |
| `make:listener <name>` | Membuat kelas event listener |
| `make:mail <name>` | Membuat kelas mailable |
| `make:middleware <name>` | Membuat kelas middleware |
| `make:migration <name>` | Membuat file migration |
| `make:model <name>` | Membuat kelas Eloquent model |
| `make:notification <name>` | Membuat kelas notification |
| `make:observer <name>` | Membuat kelas observer |
| `make:pipeline <name>` | Membuat kelas pipeline |
| `make:policy <name>` | Membuat kelas policy |
| `make:provider <name>` | Membuat kelas service provider |
| `make:repository <name>` | Membuat kelas repository |
| `make:request <name>` | Membuat kelas form request |
| `make:resource <name>` | Membuat kelas API resource |
| `make:routes <name>` | Membuat file routes |
| `make:rule <name>` | Membuat kelas validation rule |
| `make:scope <name>` | Membuat kelas query scope |
| `make:seeder <name>` | Membuat kelas seeder |
| `make:service <name>` | Membuat kelas service |
| `make:trait <name>` | Membuat trait |
| `make:view <name>` | Membuat file Blade view |
| `app:build <name>` | Membuat arsip PHAR |
| `app:inspect` | Melihat detail aplikasi |

### Opsi

Semua perintah `make:*` mendukung `--force` untuk menimpa file yang sudah ada.

| Perintah | Opsi |
|----------|------|
| `make:action` | `--force` |
| `make:cast` | `--force` |
| `make:channel` | `--force` |
| `make:command` | `--command=` (nama perintah terminal), `--force` |
| `make:component` | `--force` |
| `make:config` | `--force` |
| `make:controller` | `-i, --invokable`, `-m, --model=`, `-r, --resource`, `--api`, `-R, --requests`, `--force` |
| `make:dto` | `--force` |
| `make:enum` | `--force` |
| `make:event` | `--force` |
| `make:exception` | `--force` |
| `make:facade` | `--force` |
| `make:factory` | `-m, --model=`, `--force` |
| `make:interface` | `--force` |
| `make:job` | `--sync` (synchronous), `--force` |
| `make:lang` | `--locale=` (default: en), `--force` |
| `make:listener` | `-e, --event=`, `--queued`, `--force` |
| `make:mail` | `--markdown=`, `--force` |
| `make:middleware` | `--force` |
| `make:migration` | `--create=` (tabel dibuat), `--table=` (tabel dimodifikasi), `--path=`, `--force` |
| `make:model` | `-a, --all`, `-c, --controller`, `-f, --factory`, `-m, --migration`, `--policy`, `-s, --seed`, `-r, --resource`, `--api`, `-R, --requests`, `--force` |
| `make:notification` | `--markdown=`, `--force` |
| `make:observer` | `-m, --model=`, `--force` |
| `make:pipeline` | `--force` |
| `make:policy` | `-m, --model=`, `--guard=`, `--force` |
| `make:provider` | `--force` |
| `make:repository` | `--force` |
| `make:request` | `--force` |
| `make:resource` | `-m, --model=`, `-c, --collection`, `--force` |
| `make:routes` | `--force` |
| `make:rule` | `--implicit`, `--force` |
| `make:scope` | `--force` |
| `make:seeder` | `--force` |
| `make:service` | `--force` |
| `make:trait` | `--force` |
| `make:view` | `--force` |

## Stub Kustom

Anda dapat menyesuaikan kode yang dihasilkan dengan menerbitkan dan memodifikasi stub:

```bash
php artisan stubs:publish
```

Ini menyalin semua file stub ke `stubs/vendor/laravel-artisan/`. Edit stub mana pun dan perintah `make:*` selanjutnya akan menggunakan versi Anda.

Gunakan `--force` untuk menimpa stub yang sudah diterbitkan sebelumnya:

```bash
php artisan stubs:publish --force
```

## Mendaftarkan Perintah Kustom

```php
use Adereksisusanto\Laravel\Artisan\Kernel;

$kernel = new Kernel($app);
$kernel->registerCommand(\App\Commands\MyCommand::class);
$kernel->handle();
```

## Membuat PHAR

```bash
php artisan app:build myapp
./myapp list
```

## Berkontribusi

1. **Fork & clone**
   ```bash
   git clone https://github.com/<username-anda>/laravel-artisan.git
   cd laravel-artisan
   ```

2. **Install dependensi**
   ```bash
   composer install
   ```

3. **Buat branch**
   ```bash
   git checkout -b fitur/nama-fitur-anda
   ```

4. **Lakukan perubahan & jalankan pengecekan kualitas**
   ```bash
   composer check
   ```
   Ini menjalankan Pint (style), PHPStan (analisis statis), dan Pest (tes).

5. **Jalankan tes untuk semua versi Laravel yang didukung** (opsional, membutuhkan Docker)
   ```bash
   # Tes dengan Laravel 11
   composer require laravel/framework:^11.0 orchestra/testbench:^9.0 --no-update --dev && composer update --prefer-stable && composer test

   # Tes dengan Laravel 12
   composer require laravel/framework:^12.0 orchestra/testbench:^10.0 --no-update --dev && composer update --prefer-stable && composer test

   # Tes dengan Laravel 13
   composer require laravel/framework:^13.0 orchestra/testbench:^11.0 --no-update --dev && composer update --prefer-stable && composer test
   ```

6. **Commit & push**
   ```bash
   git add .
   git commit -m "feat: tambahkan fitur Anda"
   git push origin fitur/nama-fitur-anda
   ```

7. **Buka pull request** di [GitHub](https://github.com/adereksisusanto/laravel-artisan)

## Kontributor

[![All Contributors](https://img.shields.io/github/all-contributors/adereksisusanto/laravel-artisan?style=flat-square)](#contributors)

Terima kasih kepada orang-orang hebat berikut:

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

Kontribusi selalu diterima! Silakan buka issue atau pull request.
