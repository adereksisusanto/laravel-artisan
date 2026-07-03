<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class StubsPublishCommand extends Command
{
    protected $signature = 'stubs:publish {--force : Overwrite existing stubs}';

    protected $description = 'Publish all stubs for customization';

    public function handle(Filesystem $files): int
    {
        $stubsDir = __DIR__.'/../Stubs';
        $targetDir = base_path('stubs/vendor/laravel-artisan');

        if (! $files->isDirectory($stubsDir)) {
            $this->error('No stubs found in package.');

            return self::FAILURE;
        }

        $published = 0;
        $skipped = 0;

        foreach ($files->files($stubsDir) as $file) {
            $target = $targetDir.'/'.$file->getFilename();

            if (! $this->option('force') && $files->exists($target)) {
                $this->warn('Skipped: '.$file->getFilename().' (already exists)');
                $skipped++;

                continue;
            }

            $files->ensureDirectoryExists(dirname($target));
            $files->copy($file->getPathname(), $target);
            $this->info('Published: '.$file->getFilename());
            $published++;
        }

        if ($published > 0) {
            $this->info("\n{$published} stub(s) published to {$targetDir}");
        }

        if ($skipped > 0) {
            $this->warn("{$skipped} stub(s) skipped (use --force to overwrite)");
        }

        if ($published === 0 && $skipped === 0) {
            $this->warn('No stubs found to publish.');

            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
