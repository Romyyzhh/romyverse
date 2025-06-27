<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'painting_id', 'content'];
    
    /**
     * Get the user that wrote the comment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the painting that the comment belongs to
     */
    public function painting()
    {
        return $this->belongsTo(Painting::class);
    }
}
