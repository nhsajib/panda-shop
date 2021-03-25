<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $fillable = [
        'product_id', 'sku', 'attr_opt', 'price', 'discount_price', 'stock',
    ];

    public function product(){
    	return $this->belongsTo('App\Product', 'product_id');
    }
}
