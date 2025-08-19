<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendRegisterNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    private $details;
    public function __construct($data)
    {
        $this->details = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->details["subject"])
            ->markdown(
                'vendor.notifications.register',
                [
                    "message" => $this->details["message"],
                    "subject" => $this->details["subject"],
                    "name" => $this->details["name"],
                    "email" => $this->details["email"],
                    "password" => $this->details["password"],
                ]
            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
