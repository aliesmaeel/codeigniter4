<?php

namespace App\Services;

class EmailService
{
    public static function sendEmail($mailConfig)
    {
        helper('email_helper');

        $view = \Config\Services::renderer();
        $mail_body = $view->setVar('maildata', $mailConfig['mailData'])->render($mailConfig['template']);

        $mailConfig = array(
            'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
            'mail_from_name' => env('EMAIL_FROM_NAME'),
            'mail_recipient_email' => $mailConfig['recipient_email'],
            'mail_recipient_name' => $mailConfig['recipient_name'],
            'mail_subject' => $mailConfig['subject'],
            'mail_body' => $mail_body
        );

        return sendEmail($mailConfig);
    }
}
