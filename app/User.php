<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_type', 'active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeSearch(Builder $query, string $values = null): Builder
    {
        foreach (Str::of($values)->explode(' ') as $value) {
            if ($value) {
                return $query->orWhere('name', 'LIKE', "%$value%")
                    ->orWhere('email', 'LIKE', "%$value%");
            }
        }

        return $query;
    }

    public function scopeName(Builder $query, string $name = null): Builder
    {
        if ($name) {
            return $query->where('name', 'LIKE', "%$name%");
        }

        return $query;
    }

    public function scopeActive(Builder $query, bool $active = null): Builder
    {
        if ($active) {
            return $query->where('active', $active);
        }

        return $query;
    }

    public function scopeEmail(Builder $query, string $email = null): Builder
    {
        if ($email) {
            return $query->where('email', 'LIKE', "%$email%");
        }

        return $query;
    }

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany('App\Order');
    }

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
