<?php

namespace App\Notifications;

use App\Models\Forum;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewCommentNotification extends Notification
{
    use Queueable;

    protected $forum;

    public function __construct(Forum $forum)
    {
        $this->forum = $forum;
    }

    public function via($notifiable)
    {
        return ['database']; // Simpan ke database, bisa ditambah 'mail' nanti
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Ada komentar baru di forum: ' . $this->forum->title,
            'forum_id' => $this->forum->id,
        ];
    }
}
