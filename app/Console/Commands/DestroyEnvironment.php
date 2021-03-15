<?php

declare(strict_types=1);

namespace CzechitasApp\Console\Commands;

use Illuminate\Console\Command;

class DestroyEnvironment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'destroy-env';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'If possible, will clean all DB tables';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $direct = \in_array(\dbTablePrefix(), \config('czechitas.keep_prefixes'));
        $trimmed = \in_array(\trim(\dbTablePrefix(), ' _-'), \config('czechitas.keep_prefixes'));
        if ($direct || $trimmed) {
            \printf("Prefix '%s' should be ignored, nothing is happening\n", \dbTablePrefix());

            return 0;
        }

        $this->call('backup-database');

        $this->call('migrate:reset', ['--force' => true]);

        $migrator = \resolve('migrator');

        if ($migrator->repositoryExists()) {
            $migrator->deleteRepository();
        }

        $this->info(\sprintf('All tables %s* are gone. Good bye', \dbTablePrefix()));

        return 0;
    }
}
