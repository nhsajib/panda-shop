<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopSetting extends Model
{
    protected $fillable = [
        'option_name', 'img', 'url', 'option1', 'option2', 'option2', 'text',
    ];
}
