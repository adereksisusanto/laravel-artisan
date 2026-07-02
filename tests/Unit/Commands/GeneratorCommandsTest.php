<?php

use Adereksisusanto\Laravel\Artisan\Commands\MakeActionCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeArtisanCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeCastCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeChannelCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeComponentCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeDTOCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeEnumCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeEventCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeExceptionCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeFacadeCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeFactoryCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeInterfaceCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeJobCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeListenerCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeMailCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeMiddlewareCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeModelCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeNotificationCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeObserverCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakePipelineCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakePolicyCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeProviderCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeRepositoryCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeRequestCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeResourceCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeRuleCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeScopeCommand;
use Adereksisusanto\Laravel\Artisan\Commands\MakeSeederCommand;
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
    [MakeCastCommand::class, 'MyCast', 'make:cast', 'Casts', 'class'],
    [MakeChannelCommand::class, 'MyChannel', 'make:channel', 'Broadcasting', 'class'],
    [MakeComponentCommand::class, 'MyComponent', 'make:component', 'View/Components', 'class'],
    [MakeDTOCommand::class, 'MyDTO', 'make:dto', 'DTOs', 'class'],
    [MakeEnumCommand::class, 'MyEnum', 'make:enum', 'Enums', 'enum'],
    [MakeEventCommand::class, 'MyEvent', 'make:event', 'Events', 'class'],
    [MakeExceptionCommand::class, 'MyException', 'make:exception', 'Exceptions', 'class'],
    [MakeFacadeCommand::class, 'MyFacade', 'make:facade', 'Facades', 'class'],
    [MakeInterfaceCommand::class, 'MyInterface', 'make:interface', 'Contracts', 'interface'],
    [MakeJobCommand::class, 'MyJob', 'make:job', 'Jobs', 'class'],
    [MakeListenerCommand::class, 'MyListener', 'make:listener', 'Listeners', 'class'],
    [MakeMailCommand::class, 'MyMail', 'make:mail', 'Mail', 'class'],
    [MakeMiddlewareCommand::class, 'MyMiddleware', 'make:middleware', 'Http/Middleware', 'class'],
    [MakeModelCommand::class, 'MyModel', 'make:model', 'Models', 'class'],
    [MakeNotificationCommand::class, 'MyNotification', 'make:notification', 'Notifications', 'class'],
    [MakeObserverCommand::class, 'MyObserver', 'make:observer', 'Observers', 'class'],
    [MakePipelineCommand::class, 'MyPipeline', 'make:pipeline', 'Pipelines', 'class'],
    [MakePolicyCommand::class, 'MyPolicy', 'make:policy', 'Policies', 'class'],
    [MakeProviderCommand::class, 'MyProvider', 'make:provider', 'Providers', 'class'],
    [MakeFactoryCommand::class, 'MyFactory', 'make:factory', 'Database/Factories', 'class'],
    [MakeRepositoryCommand::class, 'MyRepo', 'make:repository', 'Repositories', 'class'],
    [MakeRequestCommand::class, 'MyRequest', 'make:request', 'Http/Requests', 'class'],
    [MakeResourceCommand::class, 'MyResource', 'make:resource', 'Http/Resources', 'class'],
    [MakeRuleCommand::class, 'MyRule', 'make:rule', 'Rules', 'class'],
    [MakeScopeCommand::class, 'MyScope', 'make:scope', 'Scopes', 'class'],
    [MakeSeederCommand::class, 'MySeeder', 'make:seeder', 'Database/Seeders', 'class'],
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

test('exception stub extends exception and has render method', function () {
    $this->artisan('make:exception', ['name' => 'PaymentFailed'])
        ->assertSuccessful();

    $path = $this->tempDir.'/app/Exceptions/PaymentFailed.php';
    $content = $this->files->get($path);

    expect($content)->toContain('class PaymentFailed extends Exception');
    expect($content)->toContain('public function render(): string');
    expect($content)->toContain('public function report(): void');
});

test('facade stub extends Facade and has getFacadeAccessor', function () {
    $this->artisan('make:facade', ['name' => 'PaymentGateway'])
        ->assertSuccessful();

    $path = $this->tempDir.'/app/Facades/PaymentGateway.php';
    $content = $this->files->get($path);

    expect($content)->toContain('class PaymentGateway extends Facade');
    expect($content)->toContain('protected static function getFacadeAccessor(): string');
    expect($content)->toContain('return \'payment_gateway\'');
});

test('scope stub implements Scope contract', function () {
    $this->artisan('make:scope', ['name' => 'ActiveScope'])
        ->assertSuccessful();

    $path = $this->tempDir.'/app/Scopes/ActiveScope.php';
    $content = $this->files->get($path);

    expect($content)->toContain('class ActiveScope implements ScopeContract');
    expect($content)->toContain('public function apply(Builder $builder, Model $model): void');
});

test('pipeline stub has handle method with closure', function () {
    $this->artisan('make:pipeline', ['name' => 'RateLimit'])
        ->assertSuccessful();

    $path = $this->tempDir.'/app/Pipelines/RateLimit.php';
    $content = $this->files->get($path);

    expect($content)->toContain('class RateLimit');
    expect($content)->toContain('public function handle(mixed $payload, Closure $next): mixed');
});

test('cast stub implements CastsAttributes contract', function () {
    $this->artisan('make:cast', ['name' => 'JsonCast'])
        ->assertSuccessful();

    $path = $this->tempDir.'/app/Casts/JsonCast.php';
    $content = $this->files->get($path);

    expect($content)->toContain('class JsonCast implements CastsAttributes');
    expect($content)->toContain('public function get(Model $model, string $key, mixed $value, array $attributes): mixed');
    expect($content)->toContain('public function set(Model $model, string $key, mixed $value, array $attributes): mixed');
});

test('channel stub implements ShouldBroadcast', function () {
    $this->artisan('make:channel', ['name' => 'OrderChannel'])
        ->assertSuccessful();

    $path = $this->tempDir.'/app/Broadcasting/OrderChannel.php';
    $content = $this->files->get($path);

    expect($content)->toContain('class OrderChannel implements ShouldBroadcast');
    expect($content)->toContain("return new Channel('order-channel')");
});

test('component stub extends Component', function () {
    $this->artisan('make:component', ['name' => 'Alert'])
        ->assertSuccessful();

    $path = $this->tempDir.'/app/View/Components/Alert.php';
    $content = $this->files->get($path);

    expect($content)->toContain('class Alert extends Component');
    expect($content)->toContain('public function render():');
});

test('event stub uses Dispatchable', function () {
    $this->artisan('make:event', ['name' => 'OrderShipped'])
        ->assertSuccessful();

    $path = $this->tempDir.'/app/Events/OrderShipped.php';
    $content = $this->files->get($path);

    expect($content)->toContain('use Dispatchable, InteractsWithSockets, SerializesModels');
});

test('job stub implements ShouldQueue', function () {
    $this->artisan('make:job', ['name' => 'ProcessPodcast'])
        ->assertSuccessful();

    $path = $this->tempDir.'/app/Jobs/ProcessPodcast.php';
    $content = $this->files->get($path);

    expect($content)->toContain('class ProcessPodcast implements ShouldQueue');
    expect($content)->toContain('public function handle(): void');
});

test('listener stub has handle method', function () {
    $this->artisan('make:listener', ['name' => 'SendEmailNotification'])
        ->assertSuccessful();

    $path = $this->tempDir.'/app/Listeners/SendEmailNotification.php';
    $content = $this->files->get($path);

    expect($content)->toContain('class SendEmailNotification');
    expect($content)->toContain('public function handle(object $event): void');
});

test('mail stub extends Mailable', function () {
    $this->artisan('make:mail', ['name' => 'WelcomeMail'])
        ->assertSuccessful();

    $path = $this->tempDir.'/app/Mail/WelcomeMail.php';
    $content = $this->files->get($path);

    expect($content)->toContain('class WelcomeMail extends Mailable');
    expect($content)->toContain('public function envelope(): Envelope');
    expect($content)->toContain('public function content(): Content');
});

test('middleware stub has handle method', function () {
    $this->artisan('make:middleware', ['name' => 'CheckAge'])
        ->assertSuccessful();

    $path = $this->tempDir.'/app/Http/Middleware/CheckAge.php';
    $content = $this->files->get($path);

    expect($content)->toContain('class CheckAge');
    expect($content)->toContain('public function handle(Request $request, Closure $next): Response');
});

test('notification stub extends Notification', function () {
    $this->artisan('make:notification', ['name' => 'InvoicePaid'])
        ->assertSuccessful();

    $path = $this->tempDir.'/app/Notifications/InvoicePaid.php';
    $content = $this->files->get($path);

    expect($content)->toContain('class InvoicePaid extends Notification');
});

test('observer stub generates observer class', function () {
    $this->artisan('make:observer', ['name' => 'UserObserver'])
        ->assertSuccessful();

    $path = $this->tempDir.'/app/Observers/UserObserver.php';
    $content = $this->files->get($path);

    expect($content)->toContain('class UserObserver');
});

test('policy stub has authorization methods', function () {
    $this->artisan('make:policy', ['name' => 'PostPolicy'])
        ->assertSuccessful();

    $path = $this->tempDir.'/app/Policies/PostPolicy.php';
    $content = $this->files->get($path);

    expect($content)->toContain('class PostPolicy');
    expect($content)->toContain('public function viewAny(): bool');
    expect($content)->toContain('public function delete(): bool');
});

test('provider stub extends ServiceProvider', function () {
    $this->artisan('make:provider', ['name' => 'AppServiceProvider'])
        ->assertSuccessful();

    $path = $this->tempDir.'/app/Providers/AppServiceProvider.php';
    $content = $this->files->get($path);

    expect($content)->toContain('class AppServiceProvider extends ServiceProvider');
    expect($content)->toContain('public function register(): void');
    expect($content)->toContain('public function boot(): void');
});

test('request stub extends FormRequest', function () {
    $this->artisan('make:request', ['name' => 'StoreUserRequest'])
        ->assertSuccessful();

    $path = $this->tempDir.'/app/Http/Requests/StoreUserRequest.php';
    $content = $this->files->get($path);

    expect($content)->toContain('class StoreUserRequest extends FormRequest');
    expect($content)->toContain('public function rules(): array');
});

test('resource stub extends JsonResource', function () {
    $this->artisan('make:resource', ['name' => 'UserResource'])
        ->assertSuccessful();

    $path = $this->tempDir.'/app/Http/Resources/UserResource.php';
    $content = $this->files->get($path);

    expect($content)->toContain('class UserResource extends JsonResource');
});

test('rule stub implements ValidationRule', function () {
    $this->artisan('make:rule', ['name' => 'Uppercase'])
        ->assertSuccessful();

    $path = $this->tempDir.'/app/Rules/Uppercase.php';
    $content = $this->files->get($path);

    expect($content)->toContain('class Uppercase implements ValidationRule');
    expect($content)->toContain('public function validate(string $attribute, mixed $value, Closure $fail): void');
});

test('model stub extends Model', function () {
    $this->artisan('make:model', ['name' => 'Product'])
        ->assertSuccessful();

    $path = $this->tempDir.'/app/Models/Product.php';
    $content = $this->files->get($path);

    expect($content)->toContain('class Product extends Model');
    expect($content)->toContain('protected $fillable = [');
    expect($content)->toContain('protected function casts(): array');
});

test('factory stub extends Factory', function () {
    $this->artisan('make:factory', ['name' => 'ProductFactory'])
        ->assertSuccessful();

    $path = $this->tempDir.'/app/Database/Factories/ProductFactory.php';
    $content = $this->files->get($path);

    expect($content)->toContain('class ProductFactory extends Factory');
    expect($content)->toContain('public function definition(): array');
});

test('seeder stub extends Seeder', function () {
    $this->artisan('make:seeder', ['name' => 'DatabaseSeeder'])
        ->assertSuccessful();

    $path = $this->tempDir.'/app/Database/Seeders/DatabaseSeeder.php';
    $content = $this->files->get($path);

    expect($content)->toContain('class DatabaseSeeder extends Seeder');
    expect($content)->toContain('public function run(): void');
});

test('migration stub generates migration file', function () {
    $this->files->ensureDirectoryExists($this->tempDir.'/database/migrations');
    $this->app->useDatabasePath($this->tempDir.'/database');

    $this->artisan('make:migration', ['name' => 'create_users_table'])
        ->assertSuccessful();

    $files = $this->files->files($this->tempDir.'/database/migrations');
    expect($files)->toHaveCount(1);

    $content = $this->files->get($files[0]->getPathname());
    expect($content)->toContain("Schema::create('users'");
    expect($content)->toContain('public function up(): void');
    expect($content)->toContain('public function down(): void');
});

test('migration returns failure when file already exists', function () {
    $this->files->ensureDirectoryExists($this->tempDir.'/database/migrations');
    $this->app->useDatabasePath($this->tempDir.'/database');

    $this->artisan('make:migration', ['name' => 'create_users_table'])
        ->assertSuccessful();

    $this->artisan('make:migration', ['name' => 'create_users_table'])
        ->assertFailed();
});

test('view stub generates blade file', function () {
    $this->files->ensureDirectoryExists($this->tempDir.'/resources/views');
    $this->app->instance('path.resources', $this->tempDir.'/resources');

    $this->artisan('make:view', ['name' => 'welcome'])
        ->assertSuccessful();

    $path = $this->tempDir.'/resources/views/welcome.blade.php';
    expect($path)->toBeFile();

    $content = $this->files->get($path);
    expect($content)->toContain('<h1>welcome Component</h1>');
});

test('view returns failure when file already exists', function () {
    $this->files->ensureDirectoryExists($this->tempDir.'/resources/views');
    $this->app->instance('path.resources', $this->tempDir.'/resources');

    $this->artisan('make:view', ['name' => 'welcome'])
        ->assertSuccessful();

    $this->artisan('make:view', ['name' => 'welcome'])
        ->assertFailed();
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
        ['make:action', 'TestAction'],
        ['make:cast', 'TestCast'],
        ['make:channel', 'TestChannel'],
        ['make:command', 'TestCommand'],
        ['make:component', 'TestComponent'],
        ['make:dto', 'TestDTO'],
        ['make:enum', 'TestEnum'],
        ['make:event', 'TestEvent'],
        ['make:exception', 'TestException'],
        ['make:facade', 'TestFacade'],
        ['make:interface', 'TestInterface'],
        ['make:job', 'TestJob'],
        ['make:listener', 'TestListener'],
        ['make:mail', 'TestMail'],
        ['make:middleware', 'TestMiddleware'],
        ['make:model', 'TestModel'],
        ['make:migration', 'create_test_table'],
        ['make:notification', 'TestNotification'],
        ['make:observer', 'TestObserver'],
        ['make:pipeline', 'TestPipeline'],
        ['make:policy', 'TestPolicy'],
        ['make:provider', 'TestProvider'],
        ['make:factory', 'TestFactory'],
        ['make:repository', 'TestRepo'],
        ['make:request', 'TestRequest'],
        ['make:resource', 'TestResource'],
        ['make:rule', 'TestRule'],
        ['make:scope', 'TestScope'],
        ['make:seeder', 'TestSeeder'],
        ['make:service', 'TestService'],
        ['make:trait', 'TestTrait'],
    ];

    foreach ($commands as [$signature, $name]) {
        $this->artisan($signature, ['name' => $name])->assertSuccessful();
    }

    $this->files->ensureDirectoryExists($this->tempDir.'/database/migrations');
    $this->app->useDatabasePath($this->tempDir.'/database');

    $files = $this->files->allFiles($this->tempDir.'/app');
    foreach ($this->files->files($this->tempDir.'/database/migrations') as $file) {
        $files[] = $file;
    }
    foreach ($files as $file) {
        $result = shell_exec('php -l '.escapeshellarg($file->getPathname()).' 2>&1');
        expect($result)->toContain('No syntax errors');
    }
});
