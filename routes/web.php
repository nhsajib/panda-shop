<?php

use Illuminate\Support\Facades\Route;
use App\Cart;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Admin Routes
Route::middleware(['auth:sanctum', 'isAdmin'])->prefix('admin')->namespace('ADMIN')->group(function(){
	Route::get('/', 'AdminController@dashboard')->name('admin.dashboard');
	Route::get('/top-category', 'AdminController@topcategory')->name('admin.topcategory');
	Route::get('/category', 'AdminController@category')->name('admin.category');
	Route::get('/add-product', 'AdminController@addproduct')->name('admin.addproduct');
	Route::get('/viewallproduct', 'AdminController@allproduct')->name('admin.allproduct');
	Route::get('/shipping', 'AdminController@shipping')->name('admin.shipping');
	Route::get('/product/approve', 'AdminController@approve')->name('admin.approve');
	Route::get('/orders', 'AdminController@orders')->name('admin.orders');
	Route::get('/inshipping', 'AdminController@inshipping')->name('admin.inshipping');
	Route::get('/complete/orders', 'AdminController@completeorder')->name('admin.completeorder');
	Route::get('/setting/slider-setting', 'AdminController@heroslider')->name('admin.homesetting');
	Route::get('/setting/featured-setting', 'AdminController@featured')->name('admin.featured');
	Route::get('/setting/latest-collection', 'AdminController@latestcollection')->name('admin.latest');
	Route::get('/setting/general-info', 'AdminController@generalinfo')->name('admin.geninfo');
	
	//Publishd Product Preview
	Route::get('/product/publishpreview/{id}', 'AdminController@publishpreview')->name('admin.publishpreview');
});

// Shop Routes
Route::namespace('SHOP')->group(function(){

	Route::get('/', 'ShopController@home')->name('home');

	// Route::get('/', 'ShopController@home')->name('home');
	Route::get('/shop', 'ShopController@shop')->name('shop');
	Route::get('/shop/price/range', 'ShopController@pricefilter')->name('shop.pricerange');
	Route::get('/shop/{id}-{title}', 'ShopController@product')->name('shop.product');
	Route::get('/shop/category/{catid}-{name}', 'ShopController@category')->name('shop.category');
	
	Route::get('/shop/attrbyid/{id}', 'ShopController@attrbyid');
	Route::get('/shop/short/{shortby}-{order}', 'ShopController@filter')->name('shop.filter');
	Route::get('/shop/short/{catid}-{name}/{shortby}-{order}', 'ShopController@catfilter')->name('shop.cat.filter');

	Route::get('/shop/cart', 'CartController@cart')->name('shop.cart');
	Route::post('/shop/cart', 'CartController@addtocart');
	Route::get('/shop/cart/{id}', 'CartController@remove')->name('cart.remove');
	Route::post('/shop/cart/updatecart', 'CartController@updatecart')->name('updatecart');
	
	Route::post('/shop/order', 'OrderController@createorder')->name('shop.order')->middleware('auth:sanctum');
	Route::get('/shop/orderlist', 'OrderController@orderlist')->name('shop.orderlist')->middleware('auth:sanctum');

	Route::post('/product/review', 'ReviewController@postcomment')->name('product.review')->middleware('auth:sanctum');
});

// Admin Panel and User Panel ShopController
	Route::get('/shop/invoice/{id}', 'PDFController@invoice')->name('invoice.download');




Auth::Routes();
Route::get('/otp/{id}', 'Auth\OtpController@otpform')->name('otp.form');
Route::post('/check-otp', 'Auth\OtpController@checkotp')->name('otp');

// Route::fallback(function () {
//     return \Response::view('errors.404');
// });

// View Composer
View::composer('shop.layout.header', function ($view) {
	$cartitems = Cart::where('cart_id', session('cart'))->sum('qty');
    $view->with('cartitems', $cartitems);
});



