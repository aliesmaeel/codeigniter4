<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use MailSlurp\Configuration;
use MailSlurp\Apis\InboxControllerApi;

function sendEmail($mailConfig)
{
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'mxslurp.click';
        $mail->SMTPAuth = true;
        $mail->Username = 'user-8d8fdeb9-88bf-4b60-b4b3-51d7199ccc3a@mailslurp.biz';
        $mail->Password = 'QizUeZCNLofEQNav6XU0yXLqxP8MKi1z';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 2525;
        $mail->setFrom($mailConfig['mail_from_email'], $mailConfig['mail_from_name']);
        $mail->addAddress('2a5a5e46-f4cf-4ae1-a3d0-f19030d6309f@mailslurp.biz', $mailConfig['mail_recipient_name']);
        $mail->isHTML(true);
        $mail->Subject = $mailConfig['mail_subject'];
        $mail->Body = $mailConfig['mail_body'];
        $mail->send();
        echo 'Message has been sent successfully';
        return true;
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;

        return false;
    }
}
