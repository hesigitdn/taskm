<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ForumUserSeeder extends Seeder
{
    public function run(): void
    {
        $forumUsers = [
            ['forum_id' => 1, 'user_id' => 1, 'created_at' => '2025-06-21 16:03:36', 'updated_at' => '2025-06-21 16:03:36'],
            ['forum_id' => 1, 'user_id' => 2, 'created_at' => '2025-06-21 16:11:39', 'updated_at' => '2025-06-21 16:11:39'],
            ['forum_id' => 2, 'user_id' => 2, 'created_at' => '2025-06-21 17:03:07', 'updated_at' => '2025-06-21 17:03:07'],
            ['forum_id' => 2, 'user_id' => 1, 'created_at' => '2025-06-21 17:26:59', 'updated_at' => '2025-06-21 17:26:59'],
        ];

        DB::table('forum_user')->insert($forumUsers);
    }
}
