<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
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
        'name',
        'slug',
        'short_description',
        'description',
        'image',
        'price',
        'visible',
        'quantity',
        'category_id'
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

    public function scopeName(Builder $query, string $name = null): Builder
    {
        if ($name) {
            return $query->where('name', 'LIKE', "%$name%");
        }

        return $query;
    }

    public function scopePrice(Builder $query, float $price = null): Builder
    {
        if ($price) {
            return $query->where('price', $price);
        }

        return $query;
    }

    public function scopeVisible(Builder $query, string $visible = null): Builder
    {
        if ($visible) {
            return $query->where('visible', $visible === 'true');
        }

        return $query;
    }

    public function scopeCategory(Builder $query, int $category = null): Builder
    {
        if ($category) {
            return $query->where('category_id', $category);
        }

        return $query;
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }
}
