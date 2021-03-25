<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    protected $fillable = [
        'topcategory_id', 'name', 'description', 'img', 'viewcount',
    ];

    public function topcategory(){
    	return $this->belongsTo('App\TopCategory', 'topcategory_id');
    }

    public function products(){
    	return $this->hasMany('App\Product', 'category_id');
    }
}


