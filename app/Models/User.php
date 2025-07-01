<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
        'bio',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function paintings()
    {
        return $this->hasMany(Painting::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Get the liked paintings
     */
    public function likedPaintings()
    {
        return $this->belongsToMany(Painting::class, 'likes', 'user_id', 'painting_id');
    }

    /**
     * Get the user's notifications
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Count unread notifications
     */
    public function unreadNotificationsCount()
    {
        return $this->notifications()->where('is_read', false)->count();
    }

    /**
     * Get the profile picture URL attribute.
     *
     * @return string
     */
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            $path = 'storage/' . $this->profile_picture;
            if (file_exists(public_path($path))) {
                return asset($path);
            }
        }
        
        return asset('images/default-profile.jpg');
    }
    
    /**
     * Get the users that are following this user.
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id')
                    ->withTimestamps();
    }
    
    /**
     * Get the users that this user is following.
     */
    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id')
                    ->withTimestamps();
    }
    
    /**
     * Check if the user is following another user.
     */
    public function isFollowing(User $user)
    {
        return $this->following()->where('following_id', $user->id)->exists();
    }
    
    /**
     * Check if the user is followed by another user.
     */
    public function isFollowedBy(User $user)
    {
        return $this->followers()->where('follower_id', $user->id)->exists();
    }
}
