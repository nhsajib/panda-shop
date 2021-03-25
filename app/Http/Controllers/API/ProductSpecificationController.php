<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ProductSpecification;
use App\Http\Resources\AdminApiCollection;

class ProductSpecificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new AdminApiCollection(ProductSpecification::all());
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
            'product_id'    => 'required',
            'spec_name'     => 'required',
            'spec_details'  => 'required',
        ]);

        $productspec = New ProductSpecification;
        $productspec->product_id = $request->product_id;
        $productspec->spec_name = $request->spec_name;
        $productspec->spec_details = $request->spec_details;
        $productspec->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new AdminApiCollection(ProductSpecification::where('product_id', '=', $id)->get());
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
        $productspec = ProductSpecification::find($id);
        $productspec->delete();
    }
}
