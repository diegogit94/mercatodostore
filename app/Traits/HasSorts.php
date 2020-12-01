<?php


namespace App\Traits;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait HasSorts
{
    public function scopeApplySorts(Builder $query, string $sort = null)
    {
        $sortFields = Str::of($sort)->explode(',');

        foreach ($sortFields as $sortField)
        {
            $direction = 'asc';

            if (Str::of($sortField)->startsWith('-')) {
                $direction = 'desc';
                $sortField = Str::of($sortField)->substr(1);
            }

            if ( ! collect($this->allowedSorts)->contains($sortField)) {
                abort(400);
            }

            $query->orderBy($sortField, $direction);
        }
    }
}
