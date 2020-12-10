<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
