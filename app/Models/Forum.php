<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'user_id'];

    // Forum dibuat oleh user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Forum memiliki banyak komentar
    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'forum_user')->withTimestamps();
    }

}
