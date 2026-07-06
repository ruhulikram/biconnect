<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CompleteProfile extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'url'     => route('profile.edit'),
            'message' => 'Lengkapi profil kamu agar lebih mudah ditemukan oleh rekan kolaborasi!',
        ];
    }
}
