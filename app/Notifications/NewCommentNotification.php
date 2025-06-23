<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Comment;

class NewCommentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

public function toDatabase($notifiable)
{
    return [
        'title' => 'Diskusi Baru di Forum',
        'body' => "{$this->comment->user->name} mengomentari forum: {$this->comment->forum->title}",
        'forum_id' => $this->comment->forum_id,
        'url' => route('forums.show', $this->comment->forum_id),
    ];
}

}
