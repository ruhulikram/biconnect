<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProjectRejected extends Notification
{
    use Queueable;

    public function __construct(
        public Post $post,
        public ?string $reason = null
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $message = "Project kamu \"{$this->post->title}\" ditolak oleh admin.";
        if ($this->reason) {
            $message .= " Alasan: {$this->reason}";
        }

        return [
            'post_id'    => $this->post->id,
            'post_title' => $this->post->title,
            'url'        => route('post.show', $this->post),
            'reason'     => $this->reason,
            'message'    => $message,
        ];
    }
}
