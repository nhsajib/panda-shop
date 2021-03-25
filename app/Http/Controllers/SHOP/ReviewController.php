<?php

namespace App\Http\Controllers\SHOP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Review;
use App\Product;

class ReviewController extends Controller
{
    public function postcomment(Request $request){

    	$request->validate([
    		'rating' => 'required',
    	]);

    	$review = new Review;
    	$review->user_id = 10;
    	$review->product_id = $request->product_id;
    	$review->rating = $request->rating;
    	$review->comment = $request->comment;
    	$review->save();

    	$avg_rating = Review::where('product_id', $request->product_id)->avg('rating');

    	$product = Product::find($request->product_id);
    	$product->avg_rating = $avg_rating;
    	$product->save();

    	return back();
    }
}
