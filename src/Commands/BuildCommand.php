<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Phar;

class BuildCommand extends Command
{
    protected $signature = 'app:build {name? : The name of the PHAR file}';

    protected $description = 'Build a PHAR archive of the application';

    protected Filesystem $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    public function handle(): int
    {
        $name = $this->argument('name') ?? basename(getcwd());

        if (ini_get('phar.readonly')) {
            $this->error('Cannot build PHAR: phar.readonly is enabled in php.ini');

            return self::FAILURE;
        }

        $pharPath = getcwd()."/{$name}";

        $this->info("Building PHAR archive: {$name}");
        $this->line('');

        $phar = new Phar(
            $pharPath,
            \FilesystemIterator::CURRENT_AS_FILEINFO | \FilesystemIterator::KEY_AS_FILENAME,
            $name,
        );

        $phar->startBuffering();

        $files = $this->gatherFiles();

        foreach ($files as $relative => $absolute) {
            $phar->addFile($absolute, $relative);
        }

        $phar->setStub($this->buildStub($name));
        $phar->stopBuffering();

        $this->info("PHAR created successfully: {$pharPath}");

        return self::SUCCESS;
    }

    protected function gatherFiles(): array
    {
        $files = [];

        $directories = [
            'app' => getcwd().'/app',
            'config' => getcwd().'/config',
            'vendor' => getcwd().'/vendor',
        ];

        foreach ($directories as $base) {
            if (! $this->files->isDirectory($base)) {
                continue;
            }

            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($base, \RecursiveDirectoryIterator::SKIP_DOTS),
            );

            foreach ($iterator as $file) {
                if ($file->isFile()) {
                    $relative = str_replace(getcwd().'/', '', $file->getPathname());
                    $files[$relative] = $file->getPathname();
                }
            }
        }

        return $files;
    }

    protected function buildStub(string $name): string
    {
        return sprintf(
            "#!/usr/bin/env php\n<?php\n\nPhar::mapPhar('%s');\n\nrequire 'phar://%s/vendor/autoload.php';\n\n\$app = \\Adereksisusanto\\Laravel\\Artisan\\Application::create(__DIR__);\n\$kernel = new \\Adereksisusanto\\Laravel\\Artisan\\Kernel(\$app);\n\$status = \$kernel->handle();\n\$kernel->terminate(\$status);\n\n__HALT_COMPILER();",
            $name,
            $name,
        );
    }
}
