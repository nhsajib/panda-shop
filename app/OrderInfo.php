<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderInfo extends Model
{
    protected $fillable = [
        'user_id', 'ship_name', 'ship_mobile', 'ship_address_1', 'ship_address_2', 'ship_city', 'ship_state', 'bill_name', 'bill_mobile', 'bill_address_1', 'bill_address_2', 'bill_city', 'bill_state', 'transaction_id', 'currency', 'amount', 'shipping_charge', 'payment_status', 'order_status'
    ];

    public function orderitems(){
    	return $this->hasMany('App\Order', 'order_id');
    }
}
