<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class InterestSelected extends Notification
{
    use Queueable;

    public function __construct(
        public Post $post
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'post_id'    => $this->post->id,
            'post_title' => $this->post->title,
            'url'        => route('post.show', $this->post),
            'message'    => "Selamat! Kamu terpilih sebagai kandidat untuk project \"{$this->post->title}\". Pemilik project akan segera menghubungimu.",
        ];
    }
}
