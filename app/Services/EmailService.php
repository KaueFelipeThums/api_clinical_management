<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class EmailService
{

    /**
     * Enviar E-mail
     * 
     * @param string|array $to
     * @param string $subject
     * @param string $content
     * @return void
     */
    public static function sendEmail(string|array $to, string $subject, string $content): void
    {
        $emails = is_array($to) ? (array)$to : [(string)$to];
        $emails_validated = [];

        foreach ($emails as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emails_validated[] = $email;
            }
        }

        Mail::raw($content, function ($message) use ($emails_validated, $subject, $content) {
            $message->to($emails_validated);
            $message->subject($subject);
            $message->html($content);
        });
    }
}
