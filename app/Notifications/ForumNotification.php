<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;

class ForumNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected string $title;
    protected string $body;
    protected string $url;

    /**
     * Buat notifikasi forum baru.
     *
     * @param string $title Judul notifikasi
     * @param string $body Isi notifikasi
     * @param string $url  Tautan tujuan (default '#')
     */
    public function __construct(string $title, string $body, string $url = '#')
    {
        $this->title = $title;
        $this->body = $body;
        $this->url = $url;
    }

    /**
     * Tentukan channel notifikasi (database + email).
     */
    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Format data untuk notifikasi database.
     */
    public function toDatabase($notifiable): array
    {
        return [
            'title' => $this->title,
            'body'  => $this->body,
            'url'   => $this->url,
        ];
    }

    /**
     * Format data untuk notifikasi email.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->title)
            ->line($this->body)
            ->action('Lihat Forum', $this->url);
    }
}
