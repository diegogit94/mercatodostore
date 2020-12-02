<?php


namespace App\Traits;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait HasSorts
{
    public function scopeApplySorts(Builder $query, string $sort = null)
    {
        //
    }
}
