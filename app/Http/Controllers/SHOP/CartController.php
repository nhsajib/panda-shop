<?php

namespace App\Http\Controllers\SHOP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\ProductAttribute;
use App\Shipping;
use App\Cart;
use App\Order;
use App\UserOrder;

class CartController extends Controller
{

    public function addtocart(Request $request){

        if(!$request->session()->exists('cart')){
			$request->session()->put('cart', uniqid());
        }

        $cartid = session('cart');

        $request->validate([
            'attr_id' => 'required|unique:carts,attr_id,NULL,id,cart_id,'.$cartid.'',
            'qty' => 'required',
        ], 
        [
        	'attr_id.unique' => 'This product is already in your cart',
        ]);

        $cart = new Cart;
        $cart->cart_id = $cartid;
        $cart->attr_id = $request->attr_id;
        $cart->product_id = $request->product_id;
        $cart->qty = $request->qty;
        $cart->save();
    }

    public function cart(){

    	$cartid = session('cart');

    	$usercartitems = Cart::where('cart_id', $cartid)
    						->with('product', 'attr')
    						->get();

        $shippins = Shipping::all();

        return view('shop.cart', compact('usercartitems', 'shippins'));
    }

    public function updatecart(Request $request){

    	foreach ($request->item_id as $index => $item) {
    		$cart_item = Cart::find($item);
    		$cart_item->qty = $request->qty[$index];
    		$cart_item->save();
    	}
		
		return redirect()->route('shop.cart');
    }

    public function remove($id){

    	$removeItem = Cart::find($id);
		$removeItem->delete();

		return redirect()->route('shop.cart');
    }
}
