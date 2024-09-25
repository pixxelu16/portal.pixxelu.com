<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StudentFees;
use App\Models\Reminder; 
use Carbon\Carbon;
use Log;

class PaymentController extends Controller 
{
    // Function for unpaid fees and log WhatsApp reminders
    public function sendWhatsAppReminderToStudents()
    {
        // Get the current date
        $currentDate = Carbon::now();
        // Get the date 70 days ago
        $seventyDaysAgo = $currentDate->copy()->subDays(70);
        // Get the date 30 days ago
        $thirtyDaysAgo = $currentDate->copy()->subDays(30);
    
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
    
            // Check for payments in the last 70 days
            $paymentsLast70Days = $payments->filter(function ($payment) use ($seventyDaysAgo) {
                return Carbon::parse($payment->submission_date)->greaterThanOrEqualTo($seventyDaysAgo);
            });
    
            // Check for payments in the last 30 days
            $paymentsLast30Days = $payments->filter(function ($payment) use ($thirtyDaysAgo) {
                return Carbon::parse($payment->submission_date)->greaterThanOrEqualTo($thirtyDaysAgo);
            });
    
            // Check if the student has no payments in the last 70 days
            if ($paymentsLast70Days->isEmpty()) {
                // Send reminders if no payments in the last 30 days
                if ($paymentsLast30Days->isEmpty()) {
                    // Send and log three reminders spaced 10 days apart
                    for ($i = 1; $i <= 3; $i++) {
                        $this->sendAndLogReminder($student, $i);
                    }
                }
            }
        }
    
        // Return a response
        return response()->json(['message' => 'WhatsApp reminders logged successfully.']);
    }
    
    // Function to send and log reminders
    protected function sendAndLogReminder($student, $reminderNumber)
    {
        // Check if reminder has already been sent
        $reminderExists = Reminder::where('student_id', $student->id)
            ->where('reminder_number', $reminderNumber)
            ->exists();
    
        if (!$reminderExists) {
            // Send WhatsApp reminder (log it for now)
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
