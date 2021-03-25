<?php

namespace App\Http\Controllers\SHOP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\UserOrder;
use App\Order;
use App\Cart;


class CheckoutController extends Controller
{
    public function checkout(Request $request){

    	$request->validate([
    		'name' => 'required',
            'mobile' => 'required|digits:11|numeric',
    		'address_1' => 'required',
    		'address_2' => 'nullable',
    		'city' => 'required',
    		'state' => 'required',
    		'shipping' => 'required',
    	]);


        // Save cart product to order table
        $cart_id = session('cart');
        $cart_items = Cart::where('cart_id', $cart_id)
                        ->with('product', 'attr')
                        ->get();

        foreach ($cart_items as $key => $item) {
            $orderitem = new Order;
            $orderitem->order_id = $order->id;
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
        }

        $post_data['total_amount'] = Order::where('order_id', $order->id)->sum('total')+$request->shipping;
        $post_data['currency'] = "BDT";


        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $request->name;
        $post_data['cus_email'] = 'customer@gmail.com';
        $post_data['cus_add1'] = $request->address_1;
        $post_data['cus_add2'] = $request->address_2;
        $post_data['cus_city'] = $request->city;
        $post_data['cus_state'] = $request->state;
        $post_data['cus_postcode'] = '1000';
        $post_data['cus_country'] = 'Bangladesh';
        $post_data['cus_phone'] = $request->mobile;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = $request->name;
        $post_data['ship_add1'] = $request->address_1;
        $post_data['ship_add2'] = $request->address_2;
        $post_data['ship_city'] = $request->city;
        $post_data['ship_state'] = $request->state;
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = $request->mobile;
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        #Before  going to initiate the payment order status need to insert or update as Pending.
        $update_product = DB::table('user_orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->update([
            	'name'			=> $post_data['cus_name'],
            	'email'			=> $post_data['cus_email'],
            	'phone'			=> $post_data['cus_phone'],
            	'amount'		=> $post_data['total_amount'],
            	'status'		=> 'Pending',
            	'address'		=> $post_data['cus_add1'],
            	'transaction_id'=> $post_data['tran_id'],
            	'currency'		=> $post_data['currency'],
            	'address_2'		=> $post_data['cus_add2'],
            	'city'			=> $post_data['cus_city'],
            	'state'			=> $post_data['cus_state'],
            	'shipping_charge'=> $request->shipping,
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }


    public function success(Request $request)
    {
        echo "Transaction is Successful";

        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();

        #Check order status in order tabel against the transaction id or order id.
        $order_detials = DB::table('user_orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_detials->status == 'Pending') {
            $validation = $sslc->orderValidate($tran_id, $amount, $currency, $request->all());

            if ($validation == TRUE) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */
                $update_product = DB::table('user_orders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Processing']);

                echo "<br >Transaction is successfully Completed";
            } else {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel and Transation validation failed.
                Here you need to update order status as Failed in order table.
                */
                $update_product = DB::table('user_orders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Failed']);
                echo "validation Fail";
            }
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            /*
             That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
             */
            echo "Transaction is successfully Completed";
        } else {
            #That means something wrong happened. You can redirect customer to your product page.
            echo "Invalid Transaction";
        }


    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('user_orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_detials->status == 'Pending') {
            $update_product = DB::table('user_orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Failed']);
            echo "Transaction is Falied";
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }

    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('user_orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_detials->status == 'Pending') {
            $update_product = DB::table('user_orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Canceled']);
            echo "Transaction is Cancel";
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }
    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('user_orders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($tran_id, $order_details->amount, $order_details->currency, $request->all());
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = DB::table('user_orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);

                    echo "Transaction is successfully Completed";
                } else {
                    /*
                    That means IPN worked, but Transation validation failed.
                    Here you need to update order status as Failed in order table.
                    */
                    $update_product = DB::table('user_orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Failed']);

                    echo "validation Fail";
                }

            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }

}
