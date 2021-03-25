<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shipping;
use App\Http\Resources\AdminApiCollection;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new AdminApiCollection(Shipping::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|unique:shippings',
            'price' => 'required',
            'description' => 'required',
        ]);


        $shipping = New Shipping;
        $shipping->name = $request->name;
        $shipping->price = $request->price;
        $shipping->description = $request->description;
        $shipping->save();
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
        $request->validate([
            'name'  => 'required|unique:shippings,name,'.$id,
            'price' => 'required',
            'description' => 'required',
        ]);

        $shipping = Shipping::find($id);
        $shipping->name = $request->name;
        $shipping->price = $request->price;
        $shipping->description = $request->description;
        $shipping->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shipping = Shipping::find($id);
        $shipping->delete();
    }
}
