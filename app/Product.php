<?php

namespace App;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\Comparator\Book;

class Product extends Model
{
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

//    public function visible ($product)
//    {
//        $value = $product;
//        $value = ($value == true) ? false : true;
//
//        return $value;
//    }
}
