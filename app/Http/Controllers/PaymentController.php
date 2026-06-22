<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $sid = 'AC52ce191f8684f7126e0d0bb4b26230b8'; // Twilio Account SID
    private $token = 'f31530b5151b1bdfcadec6a7e6d1fc42'; // Twilio Auth Token
    private $twilioWhatsAppNumber = 'whatsapp:+14155238886'; // WhatsApp sandbox number

    public function sendWhatsAppMessage()
    {
        $recipientNumber = 'whatsapp:+919418496408'; // The recipient's WhatsApp number

        // Message body
        $message = 'Hello, this is a test message from Twilio WhatsApp!';

        // Twilio API URL (for WhatsApp)
        $url = "https://api.twilio.com/2010-04-01/Accounts/{$this->sid}/Messages.json";

        // Data for cURL request
        $data = [
            'From' => $this->twilioWhatsAppNumber,
            'To' => $recipientNumber,
            'Body' => $message,
        ];

        // Send the cURL request
        $response = $this->sendCurlRequest($url, $data);

        return response()->json($response);
    }

    private function sendCurlRequest($url, $data)
    {
        $post = http_build_query($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_USERPWD, "{$this->sid}:{$this->token}");

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return [
                'status' => 'Failed',
                'error' => curl_error($ch)
            ];
        }

        curl_close($ch);

        return json_decode($response, true);
    }
}
