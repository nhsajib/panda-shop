<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ProductImage;
use App\Http\Resources\AdminApiCollection;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new AdminApiCollection(ProductImage::all());
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
            'image_url' => 'required',
        ],
        [
            'image_url.required' => 'Please Select Image',
        ]);

        if($request->image_url){
            //get file extention
            $extension = explode('/', mime_content_type($request->image_url))[1];
            //Generate a Unique name with file extention
            $imageName = 'product'.uniqid().'.'.$extension;
            //convert base64 to image and upload to folder
            \Image::make($request->image_url)->resize(500, 500)->save(public_path('upload/img/').$imageName);
        }

        $productimg = New ProductImage;
        $productimg->product_id = $request->product_id;
        $productimg->image_url = $imageName;
        $productimg->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new AdminApiCollection(ProductImage::where('product_id', '=', $id)->get());
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
        $productimage = ProductImage::find($id);

        $image_url = public_path('upload/img/').$productimage->image_url;
        if(file_exists($image_url)){
            unlink($image_url);
        }
        $productimage->delete();
    }
}
