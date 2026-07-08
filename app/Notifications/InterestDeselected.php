<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class InterestDeselected extends Notification
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
            'message'    => "Status kandidat kamu untuk project \"{$this->post->title}\" dibatalkan oleh pemilik project.",
        ];
    }
}
