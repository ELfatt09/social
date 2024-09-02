<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\post ;

class media extends Model
{
    use HasFactory;
    protected $table = 'medias';
    protected $fillable = [
        'post_id',
        'pfp_id',
        'file_type',
        'file_name',
        'file_path',
        'mime_type',
        'file_size',
        ] ;
    
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id');   
    }
    public function pfp(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pfp_id');   
    }
}
