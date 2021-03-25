<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TopCategory extends Model
{
    protected $fillable = [
        'name', 'description', 'img',
    ];

    public function cartories(){
		return $this->hasMany('App\Category', 'topcategory_id');
    }
}
