<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'cart_id', 'attr_id', 'product_id', 'qty',
    ];

    public function product(){
    	return $this->belongsTo('App\Product', 'product_id');
    }

    public function attr(){
    	return $this->belongsTo('App\ProductAttribute', 'attr_id');
    }
}
