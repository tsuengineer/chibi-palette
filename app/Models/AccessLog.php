<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccessLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'accessed_at',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
