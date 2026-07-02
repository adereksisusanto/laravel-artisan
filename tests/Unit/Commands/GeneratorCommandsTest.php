<?php

use Adereksisusanto\Laravel\Artisan\Commands\MakeActionCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeArtisanCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeDTOCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeEnumCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeInterfaceCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeRepositoryCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeServiceCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeTraitCommand;
use Illuminate\Filesystem\Filesystem;

beforeEach(function () {
    $this->files = new Filesystem;
    $this->tempDir = sys_get_temp_dir().'/laravel-artisan-test-'.uniqid();
    $this->files->ensureDirectoryExists($this->tempDir.'/app');
    $this->files->ensureDirectoryExists($this->tempDir.'/config');
    app()->setBasePath($this->tempDir);
});

afterEach(function () {
    $this->files->deleteDirectory($this->tempDir);
});

dataset('generatable', [
    [MakeActionCommand::class, 'ProcessAction', 'make:action', 'Actions', 'class'],
    [MakeArtisanCommand::class, 'MyCommand', 'make:command', 'Commands', 'class'],
    [MakeDTOCommand::class, 'MyDTO', 'make:dto', 'DTOs', 'class'],
    [MakeEnumCommand::class, 'MyEnum', 'make:enum', 'Enums', 'enum'],
    [MakeInterfaceCommand::class, 'MyInterface', 'make:interface', 'Contracts', 'interface'],
    [MakeRepositoryCommand::class, 'MyRepo', 'make:repository', 'Repositories', 'class'],
    [MakeServiceCommand::class, 'MyService', 'make:service', 'Services', 'class'],
    [MakeTraitCommand::class, 'MyTrait', 'make:trait', 'Traits', 'trait'],
]);

test('generates file from stub', function (string $commandClass, string $name, string $signature, string $directory, string $keyword) {
    $this->artisan($signature, ['name' => $name])
        ->assertSuccessful();

    $expectedPath = $this->tempDir.'/app/'.$directory.'/'.$name.'.php';
    expect($expectedPath)->toBeFile();

    $content = $this->files->get($expectedPath);
    expect($content)->toContain('namespace App\\'.str_replace('/', '\\', $directory));
    expect($content)->toContain($keyword.' '.$name);
})->with('generatable');

test('returns failure when file already exists', function () {
    $this->artisan('make:service', ['name' => 'UserService'])
        ->assertSuccessful();

    $this->artisan('make:service', ['name' => 'UserService'])
        ->assertFailed();
});

test('command stub generates valid command class', function () {
    $this->artisan('make:command', ['name' => 'ProcessPodcast'])
        ->assertSuccessful();

    $path = $this->tempDir.'/app/Commands/ProcessPodcast.php';
    $content = $this->files->get($path);

    expect($content)->toContain('class ProcessPodcast extends Command');
    expect($content)->toContain("signature = 'app:process-podcast'");
    expect($content)->toContain('public function handle(): int');
});

test('dto stub includes fromArray and toArray', function () {
    $this->artisan('make:dto', ['name' => 'CreateUserDTO'])
        ->assertSuccessful();

    $path = $this->tempDir.'/app/DTOs/CreateUserDTO.php';
    $content = $this->files->get($path);

    expect($content)->toContain('public static function fromArray(array $data): static');
    expect($content)->toContain('public function toArray(): array');
});

test('enum stub generates string backed enum', function () {
    $this->artisan('make:enum', ['name' => 'UserRole'])
        ->assertSuccessful();

    $path = $this->tempDir.'/app/Enums/UserRole.php';
    $content = $this->files->get($path);

    expect($content)->toContain('enum UserRole: string');
});

test('interface stub generates interface', function () {
    $this->artisan('make:interface', ['name' => 'PaymentGateway'])
        ->assertSuccessful();

    $path = $this->tempDir.'/app/Contracts/PaymentGateway.php';
    $content = $this->files->get($path);

    expect($content)->toContain('interface PaymentGateway');
});

test('trait stub generates trait', function () {
    $this->artisan('make:trait', ['name' => 'HasPermissions'])
        ->assertSuccessful();

    $path = $this->tempDir.'/app/Traits/HasPermissions.php';
    $content = $this->files->get($path);

    expect($content)->toContain('trait HasPermissions');
});

test('action stub generates invokable class', function () {
    $this->artisan('make:action', ['name' => 'SendWelcomeEmail'])
        ->assertSuccessful();

    $path = $this->tempDir.'/app/Actions/SendWelcomeEmail.php';
    $content = $this->files->get($path);

    expect($content)->toContain('public function __invoke()');
});

test('repository stub generates repository', function () {
    $this->artisan('make:repository', ['name' => 'UserRepository'])
        ->assertSuccessful();

    $path = $this->tempDir.'/app/Repositories/UserRepository.php';
    $content = $this->files->get($path);

    expect($content)->toContain('class UserRepository');
});

test('service stub generates service', function () {
    $this->artisan('make:service', ['name' => 'PaymentService'])
        ->assertSuccessful();

    $path = $this->tempDir.'/app/Services/PaymentService.php';
    $content = $this->files->get($path);

    expect($content)->toContain('class PaymentService');
});

test('all generated files are valid PHP', function () {
    $commands = [
        ['make:command', 'TestCommand'],
        ['make:service', 'TestService'],
        ['make:repository', 'TestRepo'],
        ['make:dto', 'TestDTO'],
        ['make:action', 'TestAction'],
        ['make:enum', 'TestEnum'],
        ['make:interface', 'TestInterface'],
        ['make:trait', 'TestTrait'],
    ];

    foreach ($commands as [$signature, $name]) {
        $this->artisan($signature, ['name' => $name])->assertSuccessful();
    }

    $files = $this->files->allFiles($this->tempDir.'/app');
    foreach ($files as $file) {
        $result = shell_exec('php -l '.escapeshellarg($file->getPathname()).' 2>&1');
        expect($result)->toContain('No syntax errors');
    }
});
