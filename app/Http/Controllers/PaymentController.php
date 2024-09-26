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
    // Function to send WhatsApp reminders to students for unpaid fees
    public function sendWhatsAppReminderToStudents()
    {
        // Get the current date
        $currentDate = Carbon::now();
        
        // Calculate the first, second, and last 10-day intervals of the current month
        $startOfMonth = $currentDate->copy()->startOfMonth();
        $firstReminderDate = $startOfMonth->copy()->addDays(10);
        $secondReminderDate = $startOfMonth->copy()->addDays(20);
        $endOfMonth = $startOfMonth->copy()->endOfMonth();
        
        // Get overdue dates
        $thirtyDaysAgo = $currentDate->copy()->subDays(30);
        $fortyDaysAgo = $currentDate->copy()->subDays(40);
        $fiftyDaysAgo = $currentDate->copy()->subDays(50);
        $sixtyDaysAgo = $currentDate->copy()->subDays(60);
        $seventyDaysAgo = $currentDate->copy()->subDays(70);
        
        // Get all active students
        $studentsWithUnpaidFees = User::where('user_type', 'Student')
            ->where('user_status', 'Active')
            ->with(['student_fees_detail' => function ($query) {
                $query->orderBy('submission_date', 'desc');
            }])
            ->get();

        //echo "<pre>"; print_r($studentsWithUnpaidFees->toArray());exit;    
    
        // Iterate through each student
        foreach ($studentsWithUnpaidFees as $student) {
            // Get all payment records
            $payments = $student->student_fees_detail;

            // Check for payments in the current month
            $paymentsCurrentMonth = $payments->filter(function ($payment) use ($startOfMonth) {
                return Carbon::parse($payment->submission_date)->greaterThanOrEqualTo($startOfMonth);
            });
           
            echo "<pre>"; print_r($paymentsCurrentMonth->toArray());exit;
            // If the student has paid for the current month, skip sending reminders
            if ($paymentsCurrentMonth->isNotEmpty()) {
                continue; // Skip to the next student
            }
    
            // Check for payments in the last 30, 40, 50, 60, and 70 days
            $paymentsLast30Days = $payments->filter(function ($payment) use ($thirtyDaysAgo) {
                return Carbon::parse($payment->submission_date)->greaterThanOrEqualTo($thirtyDaysAgo);
            });
            
           
            $paymentsLast40Days = $payments->filter(function ($payment) use ($fortyDaysAgo) {
                return Carbon::parse($payment->submission_date)->greaterThanOrEqualTo($fortyDaysAgo);
            });
            
          
            $paymentsLast50Days = $payments->filter(function ($payment) use ($fiftyDaysAgo) {
                return Carbon::parse($payment->submission_date)->greaterThanOrEqualTo($fiftyDaysAgo);
            });

           
            
            $paymentsLast60Days = $payments->filter(function ($payment) use ($sixtyDaysAgo) {
                return Carbon::parse($payment->submission_date)->greaterThanOrEqualTo($sixtyDaysAgo);
            });
            
            $paymentsLast70Days = $payments->filter(function ($payment) use ($seventyDaysAgo) {
                return Carbon::parse($payment->submission_date)->greaterThanOrEqualTo($seventyDaysAgo);
            });
        
            // Daily reminder for students with no payments in the last 70 days
            if ($paymentsLast70Days->isEmpty()) {
                $this->sendAndLogReminder($student, 0);
            }

            // Monthly reminders based on the last payment dates
            if ($paymentsLast60Days->isEmpty()) {
                $this->sendAndLogReminder($student, 4); // Reminder for 60-70 days
            } elseif ($paymentsLast50Days->isEmpty()) {
                $this->sendAndLogReminder($student, 5); // Reminder for 50-60 days
            } elseif ($paymentsLast40Days->isEmpty()) {
                $this->sendAndLogReminder($student, 6); // Reminder for 40-50 days
            } elseif ($paymentsLast30Days->isEmpty()) {
                $this->sendAndLogReminder($student, 7); // Reminder for 30-40 days
            }
    
            // If no payments are made in the current month, send reminders based on the current date
            if ($paymentsLast40Days->isEmpty()) {
                if ($currentDate->lessThanOrEqualTo($firstReminderDate)) {
                    // Send the first reminder within the first 10 days
                    $this->sendAndLogReminder($student, 1);
                } elseif ($currentDate->lessThanOrEqualTo($secondReminderDate)) {
                    // Send the second reminder between day 11 and day 20
                    $this->sendAndLogReminder($student, 2);
                } elseif ($currentDate->between($firstReminderDate, $secondReminderDate)) {
                    // Send a reminder for the 20-30 day period of the current month
                    $this->sendAndLogReminder($student, 8); // Reminder for 20-30 days
                } elseif ($currentDate->lessThanOrEqualTo($endOfMonth)) {
                    // Send the final reminder in the last 10 days of the month
                    $this->sendAndLogReminder($student, 3);
                }
            }
        }
    
        // Return a response
        return response()->json(['message' => 'WhatsApp reminders logged successfully.']);
    }

    // Function to send and log reminders
    protected function sendAndLogReminder($student, $reminderNumber)
    {
        // Check if the reminder has already been sent in the current month or if it's a daily reminder
        if ($reminderNumber === 0) {
            // Daily reminder logic
            $reminderExists = Reminder::where('user_id', $student->id)
                ->where('reminder_number', 0) // Identifier for daily reminders
                ->whereDate('sent_at', Carbon::today())
                ->exists();
        } else {
            // Monthly reminder logic
            $reminderExists = Reminder::where('user_id', $student->id)
                ->where('reminder_number', $reminderNumber)
                ->whereMonth('sent_at', Carbon::now()->month)
                ->exists();
        }

        if (!$reminderExists) {
            // Send WhatsApp reminder via CURL
            $this->sendWhatsAppMessage($student->student_phone_no, $student->name, $reminderNumber);

            // Store the reminder in the database
            Reminder::create([
                'user_id' => $student->id,
                'reminder_number' => $reminderNumber,
                'sent_at' => Carbon::now(),
            ]);
        }
    }

    // Function to send WhatsApp message via CURL
    protected function sendWhatsAppMessage($phoneNumber, $userName, $reminderNumber)
    {
        // Prepare the message body based on the reminder number
        $messageBody = ($reminderNumber === 0)
            ? "Dear $userName, this is a daily reminder. Your fees are still pending. Please pay as soon as possible."
            : "Dear $userName, this is reminder #$reminderNumber. Your fees are still pending for this month. Please pay as soon as possible.";

        // WhatsApp API credentials (assuming Twilio)
        $sid = 'AC52ce191f8684f7126e0d0bb4b26230b8'; 
        $token = 'e2a1708b6af5954e19cabf688e792ccd'; 
        $twilioPhoneNumber = 'whatsapp:+14155238886'; 

        // Format the phone number for WhatsApp
        $whatsappPhoneNumber = 'whatsapp:+' . $phoneNumber;

        // CURL request to send WhatsApp message via Twilio API
        $url = "https://api.twilio.com/2010-04-01/Accounts/$sid/Messages.json";

        $data = [
            'From' => $twilioPhoneNumber,
            'To' => $whatsappPhoneNumber,
            'Body' => $messageBody,
        ];

        $post = http_build_query($data);

        // Initialize CURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_USERPWD, "$sid:$token");

        // Execute the CURL request and get the response
        $response = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            Log::error("Error sending WhatsApp message: " . curl_error($ch));
        } else {
            Log::info("WhatsApp Reminder #$reminderNumber sent to $userName ($phoneNumber): $messageBody");
        }

        // Close CURL session
        curl_close($ch);
    }
}
