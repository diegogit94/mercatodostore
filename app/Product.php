<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'slug', 'short_description', 'description', 'image', 'price'
    ];

    /**
     * @var string[]
     */
    protected $casts =[
        'email_verified_at' => 'datetime',
    ];
}
