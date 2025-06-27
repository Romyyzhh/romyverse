<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Painting extends Model
{
    protected $fillable = [
        'title',
        'artist',
        'year',
        'description',
        'image',
        'image_url',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }
    
    /**
     * Check if painting is liked by given user
     */
    public function isLikedBy($user)
    {
        if (!$user) {
            return false;
        }
        
        return $this->likes()->where('user_id', $user->id)->exists();
    }
}
