<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Notifications\DeadlineReminder;
use Carbon\Carbon;

class SendDeadlineNotifications extends Command
{
    protected $signature = 'reminder:send';

    protected $description = 'Kirim notifikasi untuk tugas yang deadline-nya besok';

    public function handle()
    {
        $tasks = Task::whereDate('deadline', Carbon::tomorrow())->get();

        foreach ($tasks as $task) {
            if ($task->user) {
                $task->user->notify(new DeadlineReminder($task));
            }
        }

        $this->info('Notifikasi deadline telah dikirim.');
    }
}
