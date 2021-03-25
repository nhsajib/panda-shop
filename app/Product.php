<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'title', 'description', 'image', 'attr_opt_name', 'avg_price', 'status', 'avg_rating'
    ];

    public function category(){
    	return $this->belongsTo('App\Category', 'category_id');
    }

    public function attribute(){
    	return $this->hasMany('App\ProductAttribute', 'product_id')->orderBy('price', 'asc');
    }

    public function pimage(){
		return $this->hasMany('App\ProductImage', 'product_id');
    }

    public function spec(){
    	return $this->hasMany('App\ProductSpecification', 'product_id');
    }
}
