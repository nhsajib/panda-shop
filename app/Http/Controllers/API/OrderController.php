<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\AdminApiCollection;
use App\Http\Resources\AdminApiResource;
use App\OrderInfo;
use PDF;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = OrderInfo::with('orderitems')
                ->where('payment_amount', '>', 0)
                ->where('order_status', 'In process')
                ->paginate(10);

        return new AdminApiCollection($order);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function invoice($id){
        $data = OrderInfo::with('orderitems')->find($id);

        $pdf = PDF::loadView('shop.cusinvoice', compact('data'));
        return $pdf->download('invoice.pdf');
    }

    public function movetoship($id){
        $order = OrderInfo::find($id);
        $order->order_status = 'In shipping';
        $order->save();
    }

    public function searchorder($id){
        $order = OrderInfo::with('orderitems')
            ->where('order_status', 'In process')
            ->where('payment_amount', '>', 0)
            ->find($id);
        return new AdminApiResource($order);
    }

    public function inshipping(){
        $ship_orders = OrderInfo::with('orderitems')
                        ->where('order_status', 'In shipping')
                        ->paginate(10);
        return new AdminApiResource($ship_orders);
    }

    public function searchshiporder($id){
        $order = OrderInfo::with('orderitems')
            ->where('order_status', 'In shipping')
            ->find($id);
        return new AdminApiResource($order);
    }

    public function completeorder(Request $request){

        $complete_order = OrderInfo::find($request->id);

        $total_payment = $complete_order->payment_amount+$request->cahs_amount;
        
        $complete_order->payment_amount;
        $complete_order->order_status = 'Complete';
        $complete_order->payment_status = 'Paid';
        $complete_order->save();
    }

    public function completeorders(){
        $completeorders = OrderInfo::with('orderitems')
                        ->where('order_status', 'Complete')
                        ->paginate(10);
        return new AdminApiCollection($completeorders);
    }

    public function searchco($id){
        $completeorders = OrderInfo::with('orderitems')
                        ->where('order_status', 'Complete')
                        ->find($id);
        return new AdminApiResource($completeorders);
    }
}
