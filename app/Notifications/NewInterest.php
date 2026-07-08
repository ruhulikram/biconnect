<?php

namespace App\Notifications;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewInterest extends Notification
{
    use Queueable;

    public function __construct(
        public Post $post,
        public User $interestedUser,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'post_id'     => $this->post->id,
            'post_title'  => $this->post->title,
            'user_id'     => $this->interestedUser->id,
            'user_name'   => $this->interestedUser->name,
            'user_avatar' => $this->interestedUser->avatar_url,
            'url'         => route('post.show', $this->post),
            'message'     => "{$this->interestedUser->name} tertarik dengan project kamu \"{$this->post->title}\"",
        ];
    }
}
