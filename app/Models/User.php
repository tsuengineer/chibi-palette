<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'slug',
        'name',
        'email',
        'password',
        'profile',
        'twitter',
        'instagram',
        'rank',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function hasFavorite($post_id)
    {
        return $this->favorites->where('post_id', $post_id)->isNotEmpty();
    }

    public function avatars(): HasOne
    {
        return $this->hasOne(Avatar::class);
    }

    public function rankings(): HasMany
    {
        return $this->hasMany(Ranking::class);
    }
}
