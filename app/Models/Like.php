<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'painting_id'];
    
    /**
     * Get the user who liked
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the painting that was liked
     */
    public function painting()
    {
        return $this->belongsTo(Painting::class);
    }
}
