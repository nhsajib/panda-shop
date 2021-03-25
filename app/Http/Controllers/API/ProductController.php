<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\ProductAttribute;
use App\ProductImage;
use App\ProductSpecification;
use App\Http\Resources\AdminApiCollection;
use App\Http\Resources\AdminApiResource;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new AdminApiCollection(Product::with('category', 'attribute', 'pimage', 'spec')->paginate(8));
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
            'category_id' => 'required',
            'title' => 'required|unique:products|min:6|max:92',
            'description' => 'required|min:10',
            'image' => 'required',
        ]);

        if($request->image){
            //get file extention
            $extension = explode('/', mime_content_type($request->image))[1];
            //Generate a Unique name with file extention
            $imageName = 'p_thumb'.uniqid().'.'.$extension;
            //convert base64 to image and upload to folder
            \Image::make($request->image)->resize(342, 342)->save(public_path('upload/img/').$imageName);
        }

        $product = New Product;
        $product->category_id = $request->category_id;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->image = $imageName;
        $product->save();

        // return json('product_id' => $product->id);
        return response()->json(['prodcut_id' => $product->id]);
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
            'category_id' => 'required',
            'title' => 'required|min:6|max:92|unique:products,title,'.$id,
            'description' => 'required|min:10',
            'image' => 'required',
        ]);

        $thumb = Product::find($id)->image;

        if(strcmp($thumb, $request->image) !== 0){

            if($request->image){
                //get file extention
                $extension = explode('/', mime_content_type($request->image))[1];
                //Generate a Unique name with file extention
                $imageName = 'p_thumb'.uniqid().'.'.$extension;
                //convert base64 to image and upload to folder
                \Image::make($request->image)->resize(342, 342)->save(public_path('upload/img/').$imageName);
            }

            $old_thumb = public_path('upload/img/').$thumb;

            $product = Product::find($id);
            $product->category_id = $request->category_id;
            $product->title = $request->title;
            $product->description = $request->description;
            $product->image = $imageName;
            $product->attr_opt_name = $request->attr_opt_name;
            $product->save();

        }else{

            $product = Product::find($id);
            $product->category_id = $request->category_id;
            $product->title = $request->title;
            $product->description = $request->description;
            $product->image = $request->image;
            $product->attr_opt_name = $request->attr_opt_name;
            $product->save();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete Product and description
        $product = Product::find($id);
        $productImg = Product::find($id)->image;

        $productthumb = public_path('upload/img/').$productImg;
        if(file_exists($productthumb)){
            unlink($productthumb);
        }
        $product->delete();

        // Delete Product Attribute
        $attribute = ProductAttribute::where('product_id', '=', $id)->delete();

        // Delete Product ProductSpecification
        $spec = ProductSpecification::where('product_id', '=', $id)->delete();

        // Delete Product Image
        $pimages = ProductImage::where('product_id', '=', $id)->get();

        foreach ($pimages as $pimage) {
                    $image = ProductImage::find($pimage->id);
                    $image_url = public_path('upload/img/').$image->image_url;

                    if(file_exists($image_url)){
                        unlink($image_url);
                    }
                    $image->delete();
                }        
    }

    public function attrname(Request $request, $id)
    {
        $request->validate([
            'attr_opt_name' => 'required',
        ]);

        $product = Product::find($id);
        $product->attr_opt_name = $request->attr_opt_name;
        $product->save();
    }

    //Select all draft product
    public function unapprove(){
        return new AdminApiCollection(Product::with('category', 'attribute', 'pimage', 'spec')->where('status', 0)->paginate(5));
    }

    //Approve product
    public function approve(Request $request, $id){

        $all_attr = ProductAttribute::where('product_id', $id)->get();
        $all_attr_sum = ProductAttribute::where('product_id', $id)->sum('price');
        $attr_count = count($all_attr);
        $avg_price = $all_attr_sum/$attr_count;


        $product = Product::find($id);
        $product->avg_price = $avg_price;
        $product->status = 1;
        $product->save();
    }

    public function search($column, $query){

        if($column == 'id'){
            $product =  Product::with('category', 'attribute', 'pimage', 'spec')
                        ->where('id', $query)
                        ->get();
        }

        if($column == 'title'){
            $product =  Product::with('category', 'attribute', 'pimage', 'spec')
                        ->where('title', 'LIKE', "%$query%")
                        ->get();
        }
        
        return new AdminApiCollection($product);
    }
}
