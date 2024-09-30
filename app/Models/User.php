<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'bio',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
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

    // Relation to the profile picture
    public function pfp(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'id', 'pfp_id');
    }

    // Relation to the posts made by the user
    public function posts(): HasMany
    {
        return $this->hasMany(post::class, 'user_id', 'id');
    }
    //  response that by the user
    public function responses(): HasMany
    {
        return $this->hasMany(response::class, 'user_id', 'id');
    }

    // Relation to the users the user is following
    public function following(): HasMany
    {
        return $this->hasMany(follow::class, 'follower_id', 'id');
    }

    // Relation to the users that are following the user
    public function followers(): HasMany
    {
        return $this->hasMany(follow::class, 'following_id', 'id');
    }

    // Check if the user has a friendship with another user
    public function hasFriendshipWith(int $userId): bool
    {
        return $this->following()->where('following_id', $userId)->exists()
            && $this->followers()->where('follower_id', $userId)->exists();
    }

    // Check if the user is following another user
    public function isFollowing(int $userId): bool
    {
        return $this->following()->where('following_id', $userId)->exists();
    }
    
}

