<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Forum;

class ForumSeeder extends Seeder
{
    public function run(): void
    {
        $forums = [
            [
                'title' => 'Manajemen Proyek',
                'body' => 'Seputar Project Manager',
                'user_id' => 1,
                'created_at' => '2025-06-21 16:03:35',
                'updated_at' => '2025-06-21 16:03:35',
            ],
            [
                'title' => 'Statistika Untuk Bisnis',
                'body' => 'Selamat Bergabung',
                'user_id' => 2,
                'created_at' => '2025-06-21 17:03:07',
                'updated_at' => '2025-06-21 17:03:07',
            ],
        ];

        foreach ($forums as $forum) {
            Forum::create($forum);
        }
    }
}
