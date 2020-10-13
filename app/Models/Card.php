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
		'short_title',
		'media_folder',
		'description',
    ];

    public function clips()
    {
        return $this->hasMany(Clip::class);
    }
}
