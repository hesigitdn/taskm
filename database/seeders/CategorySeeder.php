<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Hindari truncate, gunakan delete
        Category::query()->delete();
        DB::statement('ALTER TABLE categories AUTO_INCREMENT = 1');

        $categories = [
            ['id' => 1, 'name' => 'Sistem Pendukung Keputusan'],
            ['id' => 2, 'name' => 'Manajemen Proyek'],
            ['id' => 3, 'name' => 'Statistika untuk Bisnis'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
