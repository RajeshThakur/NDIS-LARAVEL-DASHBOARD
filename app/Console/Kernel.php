<?php

namespace App\Console;

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
        Commands\BookingStatus::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('queue:listen')->everyMinute();
        $schedule->command('Booking:Status')->everyMinute();
        $schedule->command('Agreement:Provider')->daily();
        $schedule->command('Agreement:Participant')->daily();
        $schedule->command('Agreement:Worker')->daily();
        $schedule->command('ParticipantPlan:Status')->daily();
        $schedule->command('ProviderPlan:Status')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
