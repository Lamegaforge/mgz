<?php

namespace App\Models;

use App\Models\User;
use App\Models\Card;
use App\Models\Comment;
use App\Models\Favorite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Clip extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_id',
        'user_id',
        'card_id',
        'slug',
        'title',
        'game',
        'thumbnail',
        'views',
        'duration',
        'url',
        'active',
        'state',
        'approved_at',
        'created_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'approved_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'card_id' => 'integer',
        'duration' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
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
