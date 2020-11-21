<?php

namespace App\Models;

use App\Models\Clip;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
		'slug',
        'description',
		'game',
    ];

    public function clips()
    {
        return $this->hasMany(Clip::class);
    }

    public function activeClips()
    {
        return $this->hasMany(Clip::class)->where('state', 'active');
    }
}
