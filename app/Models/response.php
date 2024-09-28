<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Post;
use App\Models\user;

class response extends Model
{
    use HasFactory;
    protected $table = 'responses';
    protected $fillable = [
            'post_id',
            'user_id',
            'action',
        ] ;
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
    public function author(): BelongsTo
    {
        return $this->belongsTo(user::class, 'user_id');
    }
}
