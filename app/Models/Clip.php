<?php

namespace App\Models;

use App\Models\User;
use App\Models\Card;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Clip extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_id',
        'user_id',
        'slug',
        'title',
        'thumbnail',
        'views',
        'url',
        'active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
