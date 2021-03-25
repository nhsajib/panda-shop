<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Crypt;
use App\Product;
use App\TopCategory;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {   
        // $categories = TopCategory::with('cartories')->get();

        // $min_price = intval(Product::where('status', 1)->orderBy('avg_price', 'asc')->first()->avg_price);
        // $max_price = intval(Product::where('status', 1)->orderBy('avg_price', 'desc')->first()->avg_price);

        // View::share(['min_price' => $min_price, 'max_price'=> $max_price, 'categories' => $categories]);
    }
}
