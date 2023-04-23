<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $attributes = [
        'title' => '無題',
        'ai_model_id' => 999,
    ];

    protected $fillable = [
        'user_id',
        'ulid',
        'title',
        'prompt',
        'negative_prompt',
        'visibility_prompt',
        'steps',
        'scale',
        'seed',
        'sampler',
        'strength',
        'noise',
        'model',
        'ai_model_id',
        'description',
        'tweet',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function accessLogs(): HasMany
    {
        return $this->hasMany(AccessLog::class);
    }

    public function rankings(): HasMany
    {
        return $this->hasMany(Ranking::class);
    }

    public function avatars()
    {
        return $this->user->avatars();
    }

    public function aiModel(): BelongsTo
    {
        return $this->belongsTo(AiModel::class);
    }
}
