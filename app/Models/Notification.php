<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'from_user_id',
        'painting_id',
        'type',
        'message',
        'is_read'
    ];
    
    /**
     * Get the user who receives the notification
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the user who triggered the notification
     */
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }
    
    /**
     * Get the painting related to this notification
     */
    public function painting()
    {
        return $this->belongsTo(Painting::class);
    }
}
