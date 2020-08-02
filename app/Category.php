<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'slug', 'description',
    ];

    /**
     * @var string[]
     */
    protected $casts =[
        'email_verified_at' => 'datetime',
    ];
}
