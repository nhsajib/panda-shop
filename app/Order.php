<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_id', 'shipping_id', 'product_name', 'sku', 'price', 'qty', 'total',
    ];
}
