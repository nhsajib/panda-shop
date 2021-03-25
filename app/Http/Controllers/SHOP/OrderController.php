<?php

namespace App\Http\Controllers\SHOP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\OrderInfo;
use App\Order;
use App\Cart;
use App\ProductAttribute;
use Auth;

class OrderController extends Controller
{
    public function createorder(Request $request){
    	$request->validate([
    		'ship_name' => 'required',
            'ship_mobile' => 'required|digits:11|numeric',
    		'ship_address_1' => 'required',
    		'ship_address_2' => 'nullable',
    		'ship_city' => 'required',
    		'ship_state' => 'required',
    		'shipping' => 'required',
    	]);

    	//Make some data 
        $transaction_id = uniqid();
        $currency = 'BDT';


        $orderinfo = new OrderInfo;
        $orderinfo->user_id = Auth::user()->id;
        $orderinfo->ship_name = $request->ship_name;
        $orderinfo->ship_mobile = $request->ship_mobile;
        $orderinfo->ship_address_1 = $request->ship_address_1;
        $orderinfo->ship_address_2 = $request->ship_address_2;
        $orderinfo->ship_city = $request->ship_city;
        $orderinfo->ship_state = $request->ship_state;
        // $orderinfo->bill_name = $request->bill_name;
        // $orderinfo->bill_mobile = $request->bill_mobile;
        // $orderinfo->bill_address_1 = $request->bill_address_1;
        // $orderinfo->bill_address_2 = $request->bill_address_2;
        // $orderinfo->bill_city = $request->bill_city;
        // $orderinfo->bill_state = $request->bill_state;

        $orderinfo->transaction_id = $transaction_id;
        $orderinfo->currency = $currency;
        $orderinfo->shipping_charge = $request->shipping;
        $orderinfo->save();

        // Save cart product to order table
        $cart_id = session('cart');
        $cart_items = Cart::where('cart_id', $cart_id)
                        ->with('product', 'attr')
                        ->get();

        foreach ($cart_items as $key => $item) {
            $orderitem = new Order;
            $orderitem->order_id = $orderinfo->id;
            $orderitem->product_name = $item->product->title;
            $orderitem->sku = $item->attr->sku;
            if($item->attr->discount_price <= 0){
            $orderitem->price = $item->attr->price;
            }else{
            $orderitem->price = $item->attr->discount_price;
            }
            $orderitem->qty = $item->qty;
            if($item->attr->discount_price <= 0){
            $orderitem->total = $item->qty*$item->attr->price;
            }else{
            $orderitem->total = $item->qty*$item->attr->discount_price;
            }
            $orderitem->save();
            //Subtraction in stock Order Qty
            $attr = ProductAttribute::find($item->attr_id);
            $attr->stock = $item->attr->stock - $item->qty;
            $attr->save();
        }
        
        //Update Order Info
        $updateOrder = OrderInfo::find($orderinfo->id);
        $updateOrder->orderd_items = Order::where('order_id', $orderinfo->id)->sum('qty');
        $updateOrder->amount = Order::where('order_id', $orderinfo->id)->sum('total')+$request->shipping;
        $updateOrder->payment_status = 'Not Paid';
        $updateOrder->order_status = 'Waiting for payment';
        $updateOrder->save();

        // Remove Cart Id from Session
		session()->forget('cart');

		return redirect()->route('shop.orderlist');
    }

    public function orderlist(){

    	$orders = OrderInfo::where('user_id', Auth::user()->id)
                ->with('orderitems')
                ->OrderBy('id', 'desc')
                ->get();

    	return view('shop.orderlist', compact('orders'));
    }
}
