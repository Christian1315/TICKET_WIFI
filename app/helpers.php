<?php

function SendNotificationViaMail($data, $notificationClass)
{
    // dd($data);
    Notification::route("mail", env("MAIL_TO"))
        ->notify($notificationClass);
}
