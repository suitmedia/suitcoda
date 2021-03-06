<?php

namespace Suitcoda\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'Suitcoda\Console\Commands\NewUserCommand',
        'Suitcoda\Console\Commands\CrawlUrlCommand',
        'Suitcoda\Console\Commands\CreateSeoJsonCommand',
        'Suitcoda\Console\Commands\WorkerCommand',
        'Suitcoda\Console\Commands\InspectionCheckerCommand'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspection:check')->everyMinute();
    }
}
