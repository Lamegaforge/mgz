<?php

namespace App\Models;

use App\Models\User;
use App\Models\Clip;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'clip_id',
        'parent_comment_id',
        'content',
        'active',
        'state',
        'approved_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'approved_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clip()
    {
        return $this->belongsTo(Clip::class);
    }

    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_comment_id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_comment_id');
    }

    public function scopeActive($query)
    {
        return $query->where('state', 'active');
    }
}
