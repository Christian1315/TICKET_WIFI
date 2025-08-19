<?php

function SendNotificationViaMail($data, $notificationClass)
{
    // dd($data);
    Notification::route("mail", $data["email"])
        ->notify($notificationClass);
}
