<?php

namespace App\Models;

use App\Models\Clip;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tracking_id',
        'login',
        'display_name',
        'description',
        'profile_image_url',
        'banner_image_slug',
        'email',
        'youtube',
        'twitch',
        'instagram',
        'twitter',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'email',
        'remember_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'email_verified_at',
    ];

    public function clips()
    {
        return $this->hasMany(Clip::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(Clip::class, 'favorites');
    }
}
