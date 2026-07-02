<?php

namespace Adereksisusanto\Laravel\Artisan;

use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

class Kernel
{
    protected Application $app;

    protected array $commands = [];

    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->registerBuiltinCommands();
    }

    protected function registerBuiltinCommands(): void
    {
        $this->commands = [
            Commands\MakeActionCommand::class,
            Commands\MakeArtisanCommand::class,
            Commands\MakeDTOCommand::class,
            Commands\MakeEnumCommand::class,
            Commands\MakeInterfaceCommand::class,
            Commands\MakeRepositoryCommand::class,
            Commands\MakeServiceCommand::class,
            Commands\MakeTraitCommand::class,
            Commands\BuildCommand::class,
            Commands\InspectCommand::class,
        ];
    }

    public function registerCommand(string $commandClass): void
    {
        $this->commands[] = $commandClass;
    }

    public function registerCommands(array $commandClasses): void
    {
        $this->commands = array_merge($this->commands, $commandClasses);
    }

    protected function bootstrap(): void
    {
        foreach ($this->commands as $command) {
            $instance = $this->app->getContainer()->make($command);
            $this->app->add($instance);
        }
    }

    public function handle(?InputInterface $input = null, ?OutputInterface $output = null): int
    {
        $input = $input ?? new ArgvInput;
        $output = $output ?? new ConsoleOutput;

        $this->bootstrap();

        return $this->app->run($input, $output);
    }

    public function terminate(int $status): void
    {
        exit($status);
    }
}
