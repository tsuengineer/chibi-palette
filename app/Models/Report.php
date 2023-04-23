<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'reason',
        'name',
        'contact_details'
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
