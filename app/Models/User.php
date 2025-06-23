<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Menambahkan relasi dengan Task
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function forums()
    {
        return $this->hasMany(Forum::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function joinedForums()
    {
        return $this->belongsToMany(Forum::class, 'forum_user')->withTimestamps();
    }

    public function replies()
{
    return $this->hasMany(\App\Models\Comment::class, 'parent_id')->whereNotNull('parent_id');
}

}
