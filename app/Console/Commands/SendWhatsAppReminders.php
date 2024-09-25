<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Reminder;
use Carbon\Carbon;
use Log;

class SendWhatsAppReminders extends Command
{
    // The name and signature of the console command
    protected $signature = 'reminders:send';

    // The console command description
    protected $description = 'Send WhatsApp reminders to students with unpaid fees';

    // Execute the console command
    public function handle()
    {
        // Get the current date, start of the current month, and the last 10, 20, and week of the current month
        $currentDate = Carbon::now();
        $startOfCurrentMonth = $currentDate->copy()->startOfMonth();
        $tenthDayOfMonth = $startOfCurrentMonth->copy()->addDays(10);
        $twentiethDayOfMonth = $startOfCurrentMonth->copy()->addDays(20);
        $lastWeekOfMonth = $startOfCurrentMonth->copy()->endOfMonth()->subWeek();

        // Get the date 60 days ago and 70 days ago for students who haven't paid in that duration
        $sixtyDaysAgo = $currentDate->copy()->subDays(60);
        $seventyDaysAgo = $currentDate->copy()->subDays(70);

        // Get all active students
        $studentsWithUnpaidFees = User::where('user_type', 'Student')
            ->where('user_status', 'Active')
            ->with(['student_fees_detail' => function ($query) {
                $query->orderBy('submission_date', 'desc');
            }])
            ->get();

        // Iterate through each student
        foreach ($studentsWithUnpaidFees as $student) {
            // Get all payment records
            $payments = $student->student_fees_detail;

            // Check for payments in the current month
            $paymentsThisMonth = $payments->filter(function ($payment) use ($startOfCurrentMonth) {
                return Carbon::parse($payment->submission_date)->greaterThanOrEqualTo($startOfCurrentMonth);
            });

            // Check if the student has any payments in the last 60-70 days
            $paymentsLast70Days = $payments->filter(function ($payment) use ($seventyDaysAgo) {
                return Carbon::parse($payment->submission_date)->greaterThanOrEqualTo($seventyDaysAgo);
            });

            // Send reminders based on the current date
            if ($paymentsThisMonth->isEmpty()) {
                // 1. First reminder: If no payment within the first 10 days
                if ($currentDate->greaterThanOrEqualTo($tenthDayOfMonth)) {
                    $this->sendAndLogReminder($student, 1);
                }

                // 2. Second reminder: If no payment by the 20th day
                if ($currentDate->greaterThanOrEqualTo($twentiethDayOfMonth)) {
                    $this->sendAndLogReminder($student, 2);
                }

                // 3. Third reminder: If no payment in the last week of the month
                if ($currentDate->greaterThanOrEqualTo($lastWeekOfMonth)) {
                    $this->sendAndLogReminder($student, 3);
                }
            }

            // If the student hasn't paid in the last 60-70 days, send the first reminder
            if ($paymentsLast70Days->isEmpty()) {
                $this->sendAndLogReminder($student, 1);
            }
        }

        $this->info('WhatsApp reminders logged successfully.');
    }

    // Function to send and log reminders
    protected function sendAndLogReminder($student, $reminderNumber)
    {
        // Check if reminder has already been sent
        $reminderExists = Reminder::where('user_id', $student->id)
            ->where('reminder_number', $reminderNumber)
            ->exists();

        if (!$reminderExists) {
            // Log the WhatsApp reminder (replace with actual sending mechanism if needed)
            $this->logWhatsAppMessage($student->student_phone_no, $student->name, $reminderNumber);

            // Store the reminder in the database
            Reminder::create([
                'user_id' => $student->id,
                'reminder_number' => $reminderNumber,
                'sent_at' => Carbon::now(),
            ]);
        }
    }

    // Function to log WhatsApp message
    protected function logWhatsAppMessage($phoneNumber, $userName, $reminderNumber)
    {
        // Message body based on reminder number
        $messageBody = "Dear $userName, this is reminder #$reminderNumber. Your fees are still pending. Please pay as soon as possible.";

        // Log the message
        Log::info("WhatsApp Reminder #$reminderNumber sent to $userName ($phoneNumber): $messageBody");
    }
}
