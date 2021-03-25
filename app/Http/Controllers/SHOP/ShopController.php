<?php

namespace App\Http\Controllers\SHOP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Product;
use App\ProductAttribute;
use App\TopCategory;
use App\Category;
use App\Review;
use App\ShopSetting;
use App\User;


class ShopController extends Controller
{
    public function home(){

        //Hero Slider
        $heroslider = ShopSetting::where('option_name', 'heroslides')->get();

        //Featured Products
        $fProductsid = ShopSetting::where('option_name', 'featured_product')->get();
        $FPids = array_column($fProductsid->toArray(), 'option1');
        $featured = Product::with('category', 'attribute')->whereIn('id', $FPids)->get();

        //Latest Collection
        $lcollection = ShopSetting::where('option_name', 'lcdata')->get();

        // Popular Categories
        $p_categories = Category::with('products')
                        ->take(12)
                        ->orderBy('viewcount', 'desc')
                        ->get();
                        
    	return view('shop.home', compact('heroslider', 'featured', 'lcollection', 'p_categories'));
    }

    public function shop(){

        $topcarteories = TopCategory::with('cartories')->get();

    	$products = Product::with('category', 'attribute')
                    ->where('status', 1)
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);
    	$totalitem = Product::where('status', 1)->count();
        
        $perpageitem = count($products);
        return view('shop.shop', compact('products', 'perpageitem', 'totalitem', 'topcarteories'));
    }


    public function pricefilter(Request $request){

        $topcarteories = TopCategory::with('cartories')->get();

        $products = Product::with('category', 'attribute')
                    ->where('avg_price', '>=', $request->min)
                    ->where('avg_price', '<=', $request->max)
                    ->where('status', 1)
                    ->orderBy('avg_price', 'asc')
                    ->paginate(15);
        $totalitem = Product::where('status', 1)->count();
       
        $perpageitem = count($products);
        $pricerange = ['min' => $request->min, 'max' => $request->max];

        return view('shop.shop', compact('products', 'perpageitem', 'totalitem', 'topcarteories', 'pricerange'));
    }

    public function product($id){

    	$product = Product::with('category', 'attribute', 'pimage', 'spec')->where('status', 1)->find($id);

        //Every Product View +1 in Category view count
        $categoryHit = Category::find($product->category_id);
        $categoryHit->viewcount = $categoryHit->viewcount+1;
        $categoryHit->save();

        $reletad_product = Product::with('category', 'attribute')
                            ->where('status', 1)
                            ->where('id', '!=', $id)
                            ->where('category_id', $product->category_id)
                            ->orderBy('created_at', 'desc')
                            ->take(12)
                            ->get();

        $reviews = Review::where('product_id', $id)->latest()->paginate(5);
        $avg_review = Review::where('product_id', $id)->avg('rating');

    	return view('shop.product', compact('product', 'reletad_product', 'reviews', 'avg_review'));
    }

    //Get attribute by attribute id for Variable Product
    public function attrbyid($id){
        return ProductAttribute::find($id);
    }

    public function filter($shortby, $order){

        $filter = $shortby.$order;

        $topcarteories = TopCategory::with('cartories')->get();

        $products = Product::with('category', 'attribute')
                    ->where('status', 1)
                    ->orderBy($shortby, $order)
                    ->paginate(15);
        $totalitem = Product::where('status', 1)->count();
        
        $perpageitem = count($products);
        return view('shop.shop', compact('products', 'perpageitem', 'totalitem', 'topcarteories', 'filter'));
    }

    public function category($catid, $name){

        $totalitemcounts = Product::where('category_id', $catid)->where('status', 1)->count();

        $products = Product::with('category', 'attribute')
                    ->where('status', 1)
                    ->where('category_id', $catid)
                    ->orderBy('created_at', 'desc')
                    ->paginate(16);

        $displayitemcounts = count($products);

        return view('shop.category', compact('products', 'name', 'totalitemcounts', 'displayitemcounts', 'catid'));
    }

    public function catfilter($catid, $name, $shortby, $order){

        $filter = $shortby.$order;

        $products = Product::with('category', 'attribute')
                    ->where('status', 1)
                    ->where('category_id', $catid)
                    ->orderBy($shortby, $order)
                    ->paginate(15);
        $totalitemcounts = Product::where('category_id', $catid)->where('status', 1)->count();

        $displayitemcounts = count($products);

        return view('shop.category', compact('products', 'name', 'totalitemcounts', 'displayitemcounts', 'catid', 'filter'));
    }
}
