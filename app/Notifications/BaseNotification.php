<?php

declare(strict_types=1);

namespace CzechitasApp\Notifications;

use Illuminate\Notifications\Notification;

class BaseNotification extends Notification
{
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array<string>|mixed
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string>
     */
    public function toArray(): array
    {
        return [];
    }
}
