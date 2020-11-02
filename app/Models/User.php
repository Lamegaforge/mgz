<?php

namespace App\Models;

use App\Models\Clip;
use App\Models\Achievement;
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
        'autoplay',
        'profile_image_url',
        'banner_image_slug',
        'email',
        'youtube',
        'instagram',
        'twitter',
        'points',
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

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'autoplay' => 'boolean',
    ];

    public function clips()
    {
        return $this->hasMany(Clip::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(Clip::class, 'favorites')->withTimestamps(); 
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class)->withTimestamps();
    }
}
