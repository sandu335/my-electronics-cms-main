<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // example: nightly backup at 02:30
        $schedule->command('site:backup')->dailyAt('02:30');
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
    }
}
