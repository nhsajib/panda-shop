<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!

*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Admin Routes
Route::prefix('admin')->namespace('API')->group(function(){
	Route::apiResource('top-category', 'TopCategoryController')->middleware('isAdmin');
	Route::apiResource('category', 'CategoryController')->middleware('isAdmin');
	Route::apiResource('product', 'ProductController')->middleware('isAdmin');
	Route::apiResource('product-attr', 'ProductAttributeController')->middleware('isAdmin');
	Route::apiResource('product-image', 'ProductImageController')->middleware('isAdmin');
	Route::apiResource('product-spec', 'ProductSpecificationController')->middleware('isAdmin');
	Route::apiResource('shipping', 'ShippingController')->middleware('isAdmin');
	Route::apiResource('order', 'OrderController');

	Route::get('category-all', 'CategoryController@getall')->middleware('isAdmin');
	Route::get('category/search/{query}', 'CategoryController@search')->middleware('isAdmin');

	Route::get('product/search/{column}-{query}', 'ProductController@search')->middleware('isAdmin');
	Route::put('productattrname/{id}', 'ProductController@attrname')->middleware('isAdmin');
	Route::get('product-draft', 'ProductController@unapprove')->middleware('isAdmin');
	Route::put('product-approve/{id}', 'ProductController@approve')->middleware('isAdmin');
	Route::get('order-invoice/{id}', 'OrderController@invoice');
	Route::put('order-shipping/{id}', 'OrderController@movetoship');
	Route::get('order-search/{id}', 'OrderController@searchorder');
	Route::get('order-inshipping', 'OrderController@inshipping');
	Route::get('order-inship/search/{id}', 'OrderController@searchshiporder');
	Route::post('order-complete', 'OrderController@completeorder');
	Route::get('complete-orders', 'OrderController@completeorders');
	Route::get('complete-orders/search/{id}', 'OrderController@searchco');

	Route::post('shop/setting/heroslider/add', 'ShopSettingController@addHeroImg');
	Route::get('shop/setting/heroslider/get', 'ShopSettingController@getHeroSlider');
	Route::delete('shop/setting/heroslider/delete/{id}', 'ShopSettingController@deleteHeroSlider');
	Route::get('shop/setting/featured/search/{title}', 'ShopSettingController@featProductSearch');
	Route::post('shop/setting/featured/add/{id}', 'ShopSettingController@addtoFeature');
	Route::get('shop/setting/featured/get', 'ShopSettingController@getFeatureProduct');
	Route::delete('shop/setting/featured/remove/{id}', 'ShopSettingController@removeFeatureProduct');
	Route::get('shop/setting/latest-collections/get', 'ShopSettingController@getlatestCollection');
	Route::put('shop/setting/latest-collections/update', 'ShopSettingController@latestCollection');
	Route::post('shop/setting/logos/update', 'ShopSettingController@shoplogoset');
});