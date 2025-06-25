<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'category_id',
        'deadline',
        'completed',
        'notification_minutes', // Tambahkan kolom pengaturan notifikasi
    ];
    protected $casts = [
    'deadline' => 'datetime',
];


public function category()
{
    return $this->belongsTo(Category::class);
}


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

