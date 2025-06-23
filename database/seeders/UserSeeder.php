<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Hakim Mashurridho',
                'email' => 'hakim@gmail.com',
                'password' => '$2y$12$hrb94UGqUo08/ipmx3NdSeQ.4eNoGidOvjYjv2JpQe2qZfWZcnQMy',
                'created_at' => '2025-06-21 09:06:11',
            ],
            [
                'name' => 'Diki Patriansah',
                'email' => 'diki@gmail.com',
                'password' => '$2y$12$.g8Qo5TnvlcHgOtADXuCgOqucRKhC8ZrRyQOH.J85U4mxImodzWgO',
                'created_at' => '2025-06-21 10:53:06',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
