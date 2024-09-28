<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'user_id',
        'body',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    public function comment(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function getUpvoteCountAttribute()
    {
        return Response::where('post_id', $this->id)
            ->where('action', 'upvote')
            ->count();
    }

    public function getDownvoteCountAttribute()
    {
        return Response::where('post_id', $this->id)
            ->where('action', 'downvote')
            ->count();
    }

    public function getStarCountAttribute()
    {
        return Response::where('post_id', $this->id)
            ->where('action', 'star')
            ->count();
    }

    public function getSaveCountAttribute()
    {
        return Response::where('post_id', $this->id)
            ->where('action', 'save')
            ->count();
    }
    public function isRespondedBy(User $user, string $action): bool
    {
        return Response::where('post_id', $this->id)
            ->where('user_id', $user->id)
            ->where('action', $action)
            ->exists();
    }
}

