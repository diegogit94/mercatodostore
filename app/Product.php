<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use Searchable;
    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'slug', 'short_description', 'description', 'image', 'price', 'visible',
    ];

    /**
     * @var string[]
     */
    protected $casts =[
        'email_verified_at' => 'datetime',
    ];

    public function toggleVisibility(): bool
    {
        return $this->update(['visible' => !$this->visible]);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }
}
