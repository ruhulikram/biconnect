<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProjectApproved extends Notification
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
            'message'    => "Project kamu \"{$this->post->title}\" telah disetujui oleh admin dan sekarang aktif.",
        ];
    }
}
