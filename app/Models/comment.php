<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'post_id',
        'body',
    ];
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
    public function author(): BelongsTo
    {
        return $this->belongsTo(user::class, 'user_id');
    }
}
