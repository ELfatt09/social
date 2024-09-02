<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'user_id',
        'body',
    ];
    public function author(): BelongsTo
    {
        return $this->belongsTo(user::class, 'user_id');
    }
    public function media(): HasMany
    {
        return $this->hasMany(media::class);
    }
    public function comment(): HasMany
    {
        return $this->hasMany(comment::class);
    }
}
