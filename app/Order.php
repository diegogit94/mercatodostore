<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    /**
     * @var mixed
     */
    public $request_id;

    protected $fillable = [
        'user_id',
        'request_id',
        'reference',
        'description',
        'quantity',
        'total',
        'address',
        'city',
        'province',
        'postal_code',
        'phone',
    ];

    protected $casts = [
        'transaction_information' => 'array',
        'description' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_products')
            ->withPivot('quantity', 'unit_price');
    }
}
