<?php

declare(strict_types=1);

namespace CzechitasApp\Console;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /** @var array<string> The Artisan commands provided by your application. */
    protected $commands = [];

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require \base_path('routes/console.php');
    }
}
