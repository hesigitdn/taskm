<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $comments = [
            [ 'forum_id' => 1, 'parent_id' => null, 'user_id' => 1, 'body' => 'Selamat Datang', 'attachment' => null, 'created_at' => '2025-06-21 16:58:34', 'updated_at' => '2025-06-21 18:12:27' ],
            [ 'forum_id' => 1, 'parent_id' => 2,    'user_id' => 2, 'body' => 'haloo', 'attachment' => null, 'created_at' => '2025-06-21 17:02:02', 'updated_at' => '2025-06-21 17:02:02' ],
            [ 'forum_id' => 1, 'parent_id' => 2,    'user_id' => 1, 'body' => 'mas diki', 'attachment' => null, 'created_at' => '2025-06-21 17:31:39', 'updated_at' => '2025-06-21 17:31:39' ],
            [ 'forum_id' => 1, 'parent_id' => 2,    'user_id' => 2, 'body' => 'progresss', 'attachment' => null, 'created_at' => '2025-06-21 17:49:41', 'updated_at' => '2025-06-21 17:49:41' ],
            [ 'forum_id' => 1, 'parent_id' => 2,    'user_id' => 1, 'body' => 'oke', 'attachment' => null, 'created_at' => '2025-06-21 17:52:07', 'updated_at' => '2025-06-21 17:52:07' ],
            [ 'forum_id' => 1, 'parent_id' => 2,    'user_id' => 1, 'body' => 'cek lampiran', 'attachment' => 'attachments/uu61jy39JXUwg5Xqedn5e1NuRmoU2nTXScSZ4mDz.png', 'created_at' => '2025-06-21 18:09:46', 'updated_at' => '2025-06-21 18:10:11' ],
        ];

        foreach ($comments as $comment) {
            \App\Models\Comment::create($comment);
        }
    }
}
