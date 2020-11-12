<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Count extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'slug',
        'values',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'int',
        'values' => 'int',
    ];
}
