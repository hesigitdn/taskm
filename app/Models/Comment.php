<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['forum_id', 'parent_id', 'user_id', 'body', 'attachment'];

    // Komentar milik forum
    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }

    // Komentar dibuat oleh user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke komentar induk (jika ini adalah balasan)
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // Komentar ini memiliki balasan
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
