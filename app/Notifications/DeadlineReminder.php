<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Task;

class DeadlineReminder extends Notification implements ShouldQueue
{
    use Queueable;

    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Kirim via email dan database
    }

    // INI YANG DITAMBAHKAN PADA LANGKAH 2:
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Deadline Tugas Mendekat')
            ->greeting('Halo, ' . $notifiable->name)
            ->line("Tugas berjudul **{$this->task->title}** akan jatuh tempo besok, pada {$this->task->deadline->format('d M Y')}.")
            ->action('Lihat Tugas', url('/tasks/' . $this->task->id))
            ->line('Pastikan kamu menyelesaikannya tepat waktu!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Deadline Tugas Mendekat',
            'body' => "Tugas '{$this->task->title}' akan jatuh tempo besok.",
            'task_id' => $this->task->id,
        ];
    }
}
