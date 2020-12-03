<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
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

    public $allowedSorts = ['name', 'description'];

    public function toggleVisibility(): bool
    {
        return $this->update(['visible' => !$this->visible]);
    }

    public function scopeSearch(Builder $query, string $values = null): Builder
    {
        foreach (Str::of($values)->explode(' ') as $value) {
            if ($value) {
                return $query->orWhere('name', 'LIKE', "%$value%")
                    ->orWhere('description', 'LIKE', "%$value%");
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

    public function scopeDescription(Builder $query, string $description = null): Builder
    {
        if ($description) {
            return $query->where('description', 'LIKE', "%$description%");
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

    public function scopeMonth(Builder $query, string $month = null): Builder
    {
        if ($month) {
            return $query->whereMonth('created_at', $month);
        }

        return $query;
    }

    public function scopeYear(Builder $query, string $year = null): Builder
    {
        if ($year) {
            return $query->whereYear('created_at', $year);
        }

        return $query;
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }
}
