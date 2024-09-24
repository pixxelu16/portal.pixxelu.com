<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentFees;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;

class PaymentController extends Controller
{
    // Method to check unpaid fees and send WhatsApp reminders
    public function sendWhatsAppReminderToStudents()
    {
        // Get the current date
        $currentDate = Carbon::now();

        // Get student details with unpaid fees for the current month
        $studentsWithPendingFees = User::where('user_type', 'Student')
            ->where('user_status', 'Active')
            ->with(['student_fees_detail' => function ($query) {
                $query->orderBy('submission_date', 'desc');
            }])
            ->get();

        // Send WhatsApp reminders based on the last payment date
        foreach ($studentsWithPendingFees as $student) {
            // Get the last payment record
            $lastPayment = $student->student_fees_detail->first();

            // Check if payment record exists
            if ($lastPayment) {
                $lastPaidDate = Carbon::parse($lastPayment->submission_date);
                $daysSinceLastPayment = $lastPaidDate->diffInDays($currentDate);

                // Send reminders if fees are overdue (more than 10 days)
                if ($daysSinceLastPayment >= 10 && $daysSinceLastPayment < 20) {
                    // First reminder (after 10 days)
                    $this->sendWhatsAppMessage($student->student_phone_no, $student->name, 1);
                } elseif ($daysSinceLastPayment >= 20 && $daysSinceLastPayment < 30) {
                    // Second reminder (after 20 days)
                    $this->sendWhatsAppMessage($student->student_phone_no, $student->name, 2);
                } elseif ($daysSinceLastPayment >= 30) {
                    // Third reminder (after 30 days)
                    $this->sendWhatsAppMessage($student->student_phone_no, $student->name, 3);
                }
            } else {
                // If no payment record exists, treat the student as unpaid and send the first reminder
                $this->sendWhatsAppMessage($student->student_phone_no, $student->name, 1);
            }
        }
    }

    // Function to send WhatsApp message via Twilio
    protected function sendWhatsAppMessage($phoneNumber, $userName, $reminderNumber)
    {
        // Message body based on reminder number
        $messageBody = "Dear $userName, this is reminder #$reminderNumber. Your fees are still pending. Please pay as soon as possible.";

        // Format the phone number for WhatsApp (ensure it's international)
        $formattedPhoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
        
        // Ensure the number starts with 'whatsapp:' for Twilio
        $formattedPhoneNumber = 'whatsapp:' . $formattedPhoneNumber;

        // HTTP client (using Guzzle)
        $client = new Client();

        // Request payload
        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $formattedPhoneNumber,
            'type' => 'text',
            'text' => [
                'body' => $messageBody
            ]
        ];

        // Send the request to Twilio's WhatsApp API
        try {
            $response = $client->post('https://api.twilio.com/2010-04-01/Accounts/' . env('TWILIO_SID') . '/Messages.json', [
                'auth' => [env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN')],
                'form_params' => [
                    'From' => env('TWILIO_WHATSAPP_FROM'),
                    'To' => $formattedPhoneNumber,
                    'Body' => $messageBody,
                ],
            ]);

            // Check response status
            if ($response->getStatusCode() === 201) {
                echo "WhatsApp reminder #$reminderNumber sent to $userName ($phoneNumber).";
            } else {
                echo "Failed to send WhatsApp reminder #$reminderNumber to $userName ($phoneNumber).";
            }
        } catch (\Exception $e) {
            echo "Error sending WhatsApp message: " . $e->getMessage();
        }
    }
}
