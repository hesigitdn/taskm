<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Sistem Pendukung Keputusan'],
            ['name' => 'Manajemen Proyek'],
            ['name' => 'Statistika untuk Bisnis'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
