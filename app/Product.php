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

    public function scopeName($query, $name)
    {
        if ($name)
            return $query->where('name', 'LIKE', "%$name%");
    }

    public function scopePrice($query, $price)
    {
        if ($price)
            return $query->where('price', 'LIKE', "%$price%");
    }

    public function scopeVisible($query, $visible)
    {
        if ($visible)
            return $query->where('visible', '=' , $visible);
    }

    public function scopeCategory($query, $category)
    {
        if ($category)
            return $query->where('category_id', 'LIKE', "%$category%");
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }
}
