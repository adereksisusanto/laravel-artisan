<?php

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

// ─── Force option ───────────────────────────────────────────────

test('--force overwrites existing files', function () {
    $this->artisan('make:service', ['name' => 'UserService'])->assertSuccessful();

    $this->artisan('make:service', ['name' => 'UserService'])->assertFailed();

    $this->artisan('make:service', ['name' => 'UserService', '--force' => true])->assertSuccessful();
});

test('--force on view overwrites existing file', function () {
    $this->files->ensureDirectoryExists($this->tempDir.'/resources/views');
    $this->app->instance('path.resources', $this->tempDir.'/resources');

    $this->artisan('make:view', ['name' => 'welcome'])->assertSuccessful();
    $this->artisan('make:view', ['name' => 'welcome', '--force' => true])->assertSuccessful();
});

test('--force on migration overwrites existing file', function () {
    $this->files->ensureDirectoryExists($this->tempDir.'/database/migrations');
    $this->app->useDatabasePath($this->tempDir.'/database');

    $this->artisan('make:migration', ['name' => 'create_users_table'])->assertSuccessful();
    $this->artisan('make:migration', ['name' => 'create_users_table', '--force' => true])->assertSuccessful();
});

// ─── make:model options ─────────────────────────────────────────

test('make:model --migration creates migration', function () {
    $this->artisan('make:model', ['name' => 'Product', '--migration' => true])->assertSuccessful();

    $modelPath = $this->tempDir.'/app/Models/Product.php';
    expect($modelPath)->toBeFile();

    $migrations = $this->files->files($this->tempDir.'/database/migrations');
    expect($migrations)->toHaveCount(1);

    $content = $this->files->get($migrations[0]->getPathname());
    expect($content)->toContain("Schema::create('products'");
})->skip(fn () => ! $this->files->exists($this->tempDir.'/database/migrations') && ! $this->files->makeDirectory($this->tempDir.'/database/migrations', 0755, true));

test('make:model --factory creates factory', function () {
    $this->files->ensureDirectoryExists($this->tempDir.'/database/factories');

    $this->artisan('make:model', ['name' => 'Product', '--factory' => true])->assertSuccessful();

    $factoryPath = $this->tempDir.'/database/factories/Product.php';
    expect($factoryPath)->toBeFile();
    expect($this->files->get($factoryPath))->toContain('class Product extends Factory');
});

test('make:model --seed creates seeder', function () {
    $this->files->ensureDirectoryExists($this->tempDir.'/database/seeders');

    $this->artisan('make:model', ['name' => 'Product', '--seed' => true])->assertSuccessful();

    $seederPath = $this->tempDir.'/database/seeders/ProductSeeder.php';
    expect($seederPath)->toBeFile();
    expect($this->files->get($seederPath))->toContain('class ProductSeeder extends Seeder');
});

test('make:model --policy creates policy', function () {
    $this->artisan('make:model', ['name' => 'Product', '--policy' => true])->assertSuccessful();

    $policyPath = $this->tempDir.'/app/Policies/ProductPolicy.php';
    expect($policyPath)->toBeFile();
    expect($this->files->get($policyPath))->toContain('class ProductPolicy');
});

test('make:model --controller creates controller', function () {
    $this->artisan('make:model', ['name' => 'Product', '--controller' => true])->assertSuccessful();

    $ctrlPath = $this->tempDir.'/app/Http/Controllers/ProductController.php';
    expect($ctrlPath)->toBeFile();
    expect($this->files->get($ctrlPath))->toContain('class ProductController');
});

test('make:model --controller --resource creates resource controller', function () {
    $this->artisan('make:model', ['name' => 'Product', '--controller' => true, '--resource' => true])->assertSuccessful();

    $ctrlPath = $this->tempDir.'/app/Http/Controllers/ProductController.php';
    expect($ctrlPath)->toBeFile();

    $content = $this->files->get($ctrlPath);
    expect($content)->toContain('public function index()');
    expect($content)->toContain('public function store(Request $request)');
    expect($content)->toContain('public function show($id)');
});

test('make:model --all generates everything', function () {
    $this->files->ensureDirectoryExists($this->tempDir.'/database/factories');
    $this->files->ensureDirectoryExists($this->tempDir.'/database/seeders');

    $this->artisan('make:model', ['name' => 'Post', '--all' => true])->assertSuccessful();

    expect($this->tempDir.'/app/Models/Post.php')->toBeFile();
    expect($this->tempDir.'/database/factories/Post.php')->toBeFile();
    expect($this->tempDir.'/database/seeders/PostSeeder.php')->toBeFile();
    expect($this->tempDir.'/app/Policies/PostPolicy.php')->toBeFile();
    expect($this->tempDir.'/app/Http/Controllers/PostController.php')->toBeFile();
    expect($this->tempDir.'/app/Http/Requests/StorePostRequest.php')->toBeFile();
    expect($this->tempDir.'/app/Http/Requests/UpdatePostRequest.php')->toBeFile();
});

test('make:model --requests creates form request classes', function () {
    $this->artisan('make:model', ['name' => 'Product', '--requests' => true])->assertSuccessful();

    expect($this->tempDir.'/app/Http/Requests/StoreProductRequest.php')->toBeFile();
    expect($this->tempDir.'/app/Http/Requests/UpdateProductRequest.php')->toBeFile();
});

// ─── make:controller options ────────────────────────────────────

test('make:controller --resource generates resource methods', function () {
    $this->artisan('make:controller', ['name' => 'ProductController', '--resource' => true])->assertSuccessful();

    $path = $this->tempDir.'/app/Http/Controllers/ProductController.php';
    $content = $this->files->get($path);

    expect($content)->toContain('public function index()');
    expect($content)->toContain('public function create()');
    expect($content)->toContain('public function store(Request $request)');
    expect($content)->toContain('public function show($id)');
    expect($content)->toContain('public function edit($id)');
    expect($content)->toContain('public function update(Request $request, $id)');
    expect($content)->toContain('public function destroy($id)');
});

test('make:controller --invokable generates single action', function () {
    $this->artisan('make:controller', ['name' => 'ShowDashboard', '--invokable' => true])->assertSuccessful();

    $path = $this->tempDir.'/app/Http/Controllers/ShowDashboard.php';
    $content = $this->files->get($path);

    expect($content)->toContain('class ShowDashboard');
    expect($content)->toContain('public function __invoke()');
});

test('make:controller --api excludes create and edit', function () {
    $this->artisan('make:controller', ['name' => 'ApiController', '--api' => true])->assertSuccessful();

    $path = $this->tempDir.'/app/Http/Controllers/ApiController.php';
    $content = $this->files->get($path);

    expect($content)->toContain('public function index()');
    expect($content)->toContain('public function store(Request $request)');
    expect($content)->toContain('public function show($id)');
    expect($content)->toContain('public function update(Request $request, $id)');
    expect($content)->toContain('public function destroy($id)');
    expect($content)->not->toContain('public function create()');
    expect($content)->not->toContain('public function edit($id)');
});

test('make:controller --requests generates form requests', function () {
    $this->artisan('make:controller', ['name' => 'PostController', '--requests' => true])->assertSuccessful();

    expect($this->tempDir.'/app/Http/Controllers/PostController.php')->toBeFile();
    expect($this->tempDir.'/app/Http/Requests/StorePostRequest.php')->toBeFile();
    expect($this->tempDir.'/app/Http/Requests/UpdatePostRequest.php')->toBeFile();
});

// ─── make:command --command ──────────────────────────────────────

test('make:command --command sets custom signature', function () {
    $this->artisan('make:command', ['name' => 'ProcessPodcast', '--command' => 'podcast:process'])->assertSuccessful();

    $path = $this->tempDir.'/app/Commands/ProcessPodcast.php';
    $content = $this->files->get($path);

    expect($content)->toContain("signature = 'podcast:process'");
});

// ─── make:factory --model ────────────────────────────────────────

test('make:factory --model sets model class', function () {
    $this->files->ensureDirectoryExists($this->tempDir.'/database/factories');

    $this->artisan('make:factory', ['name' => 'ProductFactory', '--model' => 'Product'])->assertSuccessful();

    $path = $this->tempDir.'/database/factories/ProductFactory.php';
    $content = $this->files->get($path);

    expect($content)->toContain('protected $model = \\App\\Models\\Product::class');
});

// ─── make:job --sync ─────────────────────────────────────────────

test('make:job --sync generates synchronous job', function () {
    $this->artisan('make:job', ['name' => 'SendReport', '--sync' => true])->assertSuccessful();

    $path = $this->tempDir.'/app/Jobs/SendReport.php';
    $content = $this->files->get($path);

    expect($content)->not->toContain('ShouldQueue');
    expect($content)->not->toContain('Queueable');
    expect($content)->toContain('class SendReport');
    expect($content)->toContain('public function handle(): void');
});

// ─── make:listener --queued ──────────────────────────────────────

test('make:listener --queued generates queued listener', function () {
    $this->artisan('make:listener', ['name' => 'SendWelcomeEmail', '--queued' => true])->assertSuccessful();

    $path = $this->tempDir.'/app/Listeners/SendWelcomeEmail.php';
    $content = $this->files->get($path);

    expect($content)->toContain('implements ShouldQueue');
    expect($content)->toContain('use Queueable');
});

// ─── make:mail --markdown ─────────────────────────────────────────

test('make:mail --markdown generates markdown mailable', function () {
    $this->artisan('make:mail', ['name' => 'WelcomeMail', '--markdown' => 'emails.welcome'])->assertSuccessful();

    $path = $this->tempDir.'/app/Mail/WelcomeMail.php';
    $content = $this->files->get($path);

    expect($content)->toContain('class WelcomeMail extends Mailable');
    expect($content)->toContain("markdown: 'emails.welcome'");
});

// ─── make:notification --markdown ─────────────────────────────────

test('make:notification --markdown generates markdown notification', function () {
    $this->artisan('make:notification', ['name' => 'InvoicePaid', '--markdown' => 'emails.invoice'])->assertSuccessful();

    $path = $this->tempDir.'/app/Notifications/InvoicePaid.php';
    $content = $this->files->get($path);

    expect($content)->toContain('class InvoicePaid extends Notification');
    expect($content)->toContain("->markdown('emails.invoice')");
});

// ─── make:resource --collection ──────────────────────────────────

test('make:resource --collection generates collection resource', function () {
    $this->artisan('make:resource', ['name' => 'UserCollection', '--collection' => true])->assertSuccessful();

    $path = $this->tempDir.'/app/Http/Resources/UserCollection.php';
    $content = $this->files->get($path);

    expect($content)->toContain('class UserCollection extends ResourceCollection');
});

// ─── make:rule --implicit ─────────────────────────────────────────

test('make:rule --implicit generates implicit rule', function () {
    $this->artisan('make:rule', ['name' => 'Uppercase', '--implicit' => true])->assertSuccessful();

    $path = $this->tempDir.'/app/Rules/Uppercase.php';
    $content = $this->files->get($path);

    expect($content)->toContain('public $implicit = true');
});

// ─── make:migration --create / --table / --path ──────────────────

test('make:migration --create generates create table migration', function () {
    $this->files->ensureDirectoryExists($this->tempDir.'/database/migrations');
    $this->app->useDatabasePath($this->tempDir.'/database');

    $this->artisan('make:migration', ['name' => 'create_products_table', '--create' => 'products'])->assertSuccessful();

    $files = $this->files->files($this->tempDir.'/database/migrations');
    expect($files)->toHaveCount(1);

    $content = $this->files->get($files[0]->getPathname());
    expect($content)->toContain("Schema::create('products'");
});

test('make:migration --path creates migration in custom path', function () {
    $this->files->ensureDirectoryExists($this->tempDir.'/custom/migrations');
    $this->app->useDatabasePath($this->tempDir.'/database');

    $this->artisan('make:migration', ['name' => 'create_users_table', '--path' => 'custom/migrations'])->assertSuccessful();

    expect($this->tempDir.'/custom/migrations')->toBeDirectory();
    $files = $this->files->files($this->tempDir.'/custom/migrations');
    expect($files)->toHaveCount(1);

    $content = $this->files->get($files[0]->getPathname());
    expect($content)->toContain("Schema::create('users'");
});

// ─── Custom paths via composer.json ──────────────────────────────

test('custom path via composer.json extra', function () {
    $composer = [
        'autoload' => ['psr-4' => ['App\\' => 'app']],
        'extra' => [
            'laravel-artisan' => [
                'paths' => [
                    'model' => 'Domain/Models',
                ],
            ],
        ],
    ];
    $this->files->put($this->tempDir.'/composer.json', json_encode($composer));

    $this->artisan('make:model', ['name' => 'Product'])->assertSuccessful();

    $path = $this->tempDir.'/app/Domain/Models/Product.php';
    expect($path)->toBeFile();

    $content = $this->files->get($path);
    expect($content)->toContain('namespace App\\Domain\\Models');
});

test('custom path for controller via composer.json', function () {
    $composer = [
        'autoload' => ['psr-4' => ['App\\' => 'app']],
        'extra' => [
            'laravel-artisan' => [
                'paths' => [
                    'controller' => 'Http/Controllers/Api',
                ],
            ],
        ],
    ];
    $this->files->put($this->tempDir.'/composer.json', json_encode($composer));

    $this->artisan('make:controller', ['name' => 'UserController'])->assertSuccessful();

    $path = $this->tempDir.'/app/Http/Controllers/Api/UserController.php';
    expect($path)->toBeFile();
});

test('custom path for migration via composer.json', function () {
    $composer = [
        'autoload' => ['psr-4' => ['App\\' => 'app']],
        'extra' => [
            'laravel-artisan' => [
                'paths' => [
                    'migration' => 'Database/Migrations',
                ],
            ],
        ],
    ];
    $this->files->put($this->tempDir.'/composer.json', json_encode($composer));
    $this->app->useDatabasePath($this->tempDir.'/database');

    $this->artisan('make:migration', ['name' => 'create_users_table'])->assertSuccessful();

    $path = $this->tempDir.'/app/Database/Migrations';
    expect($path)->toBeDirectory();

    $files = $this->files->files($path);
    expect($files)->toHaveCount(1);
});

// ─── New commands ────────────────────────────────────────────────

test('make:controller command is registered', function () {
    $this->artisan('make:controller', ['name' => 'HomeController'])->assertSuccessful();

    expect($this->tempDir.'/app/Http/Controllers/HomeController.php')->toBeFile();
});

test('make:controller basic stub', function () {
    $this->artisan('make:controller', ['name' => 'HomeController'])->assertSuccessful();

    $path = $this->tempDir.'/app/Http/Controllers/HomeController.php';
    $content = $this->files->get($path);

    expect($content)->toContain('class HomeController');
    expect($content)->toContain('//');
    expect($content)->not->toContain('public function index()');
});
