<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        //Schedule the SendWhatsAppReminders command to run daily
        $schedule->command('reminders:send')->dailyAt('10:00');
        $schedule->call(function () {
            $paymentController = new \App\Http\Controllers\PaymentController();
            $paymentController->sendWhatsAppReminderToStudents();
        })->daily(); 
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
    protected $commands = [
        \App\Console\Commands\SendWhatsAppReminders::class,
    ];
}
