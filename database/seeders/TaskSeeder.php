<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = [
            [
                'user_id' => 1,
                'category_id' => 1,
                'title' => 'Laporan Progres Project',
                'description' => null,
                'deadline' => '2025-06-23 23:15:00',
                'completed' => true,
                'created_at' => '2025-06-21 09:15:58',
                'updated_at' => '2025-06-21 14:39:30',
            ],
            [
                'user_id' => 1,
                'category_id' => 2,
                'title' => 'Gform Responden',
                'description' => null,
                'deadline' => '2025-06-16 10:26:00',
                'completed' => false,
                'created_at' => '2025-06-21 20:26:09',
                'updated_at' => '2025-06-21 20:42:52',
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}
