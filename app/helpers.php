<?php

use App\Notifications\SendNotification;

function SendNotification($receiver, $subject, $message)
{
    $data = [
        "subject" => $subject,
        "message" => $message,
    ];

    Notification::send($receiver, new SendNotification($data));
}

function Send_Notification_Via_Mail($email, $subject, $message)
{
    $data = [
        "subject" => $subject,
        "message" => $message,
    ];
    Notification::route("mail", $email)->notify(new SendNotification($data));
}