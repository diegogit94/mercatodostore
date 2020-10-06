<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * @var mixed
     */
    public $request_id;

    protected $fillable = [
        'user_id', 'request_id', 'reference', 'description', 'price'
    ];

    protected $casts = [
        'transaction_information' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
