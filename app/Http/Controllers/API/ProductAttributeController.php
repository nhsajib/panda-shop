<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ProductAttribute;
use App\Http\Resources\AdminApiCollection;

class ProductAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new AdminApiCollection(ProductAttribute::all());
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
            'product_id' => 'required',
            'sku' => 'required|unique:product_attributes',
            'attr_opt' => 'required',
            'price' => 'required',
            // 'discount_price' => 'required',
            'stock' => 'required',
        ]);

        $Productattr= New ProductAttribute;
        $Productattr->product_id = $request->product_id;
        $Productattr->sku = $request->sku;
        $Productattr->attr_opt = $request->attr_opt;
        $Productattr->price = $request->price;
        $Productattr->discount_price = $request->discount_price;
        $Productattr->stock = $request->stock;
        $Productattr->save();


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new AdminApiCollection(ProductAttribute::where('product_id', '=', $id)->get());
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
        $productattr = ProductAttribute::find($id);
        $productattr->delete();
    }
}
