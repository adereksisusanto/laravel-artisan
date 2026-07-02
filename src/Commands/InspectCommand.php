<?php

namespace Adereksisusanto\Laravel\Artisan\Commands;

use Illuminate\Console\Command;

class InspectCommand extends Command
{
    protected $signature = 'app:inspect';

    protected $description = 'Display the application configuration and environment details';

    public function handle(): int
    {
        $this->components->info('Laravel Artisan Application Inspection');
        $this->newLine();

        $this->line(' <fg=green>PHP Version:</>      '.PHP_VERSION);
        $this->line(' <fg=green>Application Path:</>  '.base_path());
        $this->line(' <fg=green>Environment:</>       '.app()->environment());
        $this->line(' <fg=green>Config Path:</>       '.config_path());

        $this->newLine();
        $this->line(' <fg=yellow>Registered Commands:</>');

        $commands = $this->getApplication()->all();
        foreach ($commands as $name => $command) {
            $this->line('   - '.$name);
        }

        return self::SUCCESS;
    }
}
