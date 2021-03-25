<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class AdminController extends Controller
{
    public function dashboard(){
    	return view('admin.dashboard');
    }

    public function topcategory(){
    	return view('admin.topcategory');
    }

    public function category(){
    	return view('admin.category');
    }

    public function addproduct(){
    	return view('admin.addproduct');
    }

    public function allproduct(){
        return view('admin.allproduct');
    }

    public function shipping(){
        return view('admin.shipping');
    }

    public function approve(){
        return view('admin.approve');
    }

    public function publishpreview($id){
        $product = Product::with('category', 'attribute', 'pimage', 'spec')->find($id);
        $reletad_product = [];
        $reviews = [];
        $avg_review = [];
        return view('shop.product', compact('product', 'reletad_product', 'reviews', 'avg_review'));
    }

    public function orders(){
        return view('admin.orders');
    }

    public function inshipping(){
        return view('admin.inshipping');
    }

    public function completeorder(){
        return view('admin.completeorders');
    }

    public function heroslider(){
        return view('admin.heroslider');
    }

    public function featured(){
        return view('admin.featuredproducts');
    }

    public function latestcollection(){
        return view('admin.latestcollections');
    }

    public function generalinfo(){
        return view('admin.geninfo');
    }
}
