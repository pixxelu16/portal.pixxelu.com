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
        //Schedule the WhatsApp reminder on the 15th day of the month
        $schedule->call(function () {
            app('App\Http\Controllers\PaymentController')->sendWhatsAppReminderToStudents();
        })->monthlyOn(15, '08:00');

        //Schedule the second reminder on the last day of the month
        $schedule->call(function () {
            app('App\Http\Controllers\PaymentController')->sendWhatsAppReminderToStudents();
        })->lastDayOfMonth('08:00'); 
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
