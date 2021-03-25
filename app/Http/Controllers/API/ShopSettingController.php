<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ShopSetting;
use App\Product;
use App\Http\Resources\AdminApiCollection;
use App\Http\Resources\AdminApiResource;

class ShopSettingController extends Controller
{
    public function addHeroImg(Request $request){

        $request->validate([
            'image' => 'required',
            'url' => 'required',
        ]);

        $extension = explode('/', mime_content_type($request->image))[1];
        $imageName = 'heroslide'.uniqid().'.'.$extension;
        \Image::make($request->image)->resize(1110, 580)->save(public_path('upload/img/').$imageName);

        $heroImg = new ShopSetting;
        $heroImg->option_name = 'heroslides';
        $heroImg->img = $imageName;
        $heroImg->url = $request->url;
        $heroImg->save();
    }

    public function getHeroSlider(){
        $heroslides = ShopSetting::where('option_name', 'heroslides')->get();
        return new AdminApiCollection($heroslides);
    }

    public function deleteHeroSlider($id){
        $slideimg = ShopSetting::find($id)->img;
        $oldimgurl = public_path('upload/img/').$slideimg;
        if(file_exists($oldimgurl)){
            unlink($oldimgurl);
        }

        $heroSlide = ShopSetting::find($id);
        $heroSlide->delete();
    }

    public function featProductSearch($title){
        $proudct = Product::with('category', 'attribute')
                    ->where('title', 'LIKE', "%$title%")
                    ->take(3)
                    ->get();

        return $proudct;
    }

    public function addtoFeature($id){
        $featureProduct = new ShopSetting;
        $featureProduct->option_name = 'featured_product';
        $featureProduct->option1 = $id;
        $featureProduct->save();
    }

    public function getFeatureProduct(){
        $fProductsid = ShopSetting::where('option_name', 'featured_product')->get();

        $FPids = array_column($fProductsid->toArray(), 'option1');
        
        $FeaturedProducts = Product::with('category', 'attribute')->whereIn('id', $FPids)->get();

        return $FeaturedProducts;
    }

    public function removeFeatureProduct($id){
        $fproduct = ShopSetting::where('option_name', 'featured_product')
                    ->where('option1', $id);
        $fproduct->delete();
    }

    public function getlatestCollection(){
        $lc = ShopSetting::where('option_name', 'lcdata')->get();
        return $lc;
    }

    public function latestCollection(Request $request){

        $request->validate([
            'title'     => 'required',
            'desc'      => 'required',
            'btntext'   => 'required',
            'btnurl'    => 'required',
            'image'     => 'required',
            //Section Right
            'title2'    => 'required',
            'desc2'     => 'required',
            'btntext2'  => 'required',
            'btnurl2'   => 'required',
            'image2'    => 'required',
        ]);
        
        $oldimg = ShopSetting::find($request->id)->img;
        $oldimg2 = ShopSetting::find($request->id2)->img;

        //If Not Change in any Image
        if($request->image == $oldimg && $request->image2 == $oldimg2){

            $lc = ShopSetting::find($request->id);
            $lc->url = $request->btnurl;
            $lc->option1 = $request->title;
            $lc->option2 = $request->btntext;
            $lc->text = $request->desc;
            $lc->save();

            $lc = ShopSetting::find($request->id2);
            $lc->url = $request->btnurl2;
            $lc->option1 = $request->title2;
            $lc->option2 = $request->btntext2;
            $lc->text = $request->desc2;
            $lc->save();
        }

        // If Change in tow Image
        if($request->image != $oldimg && $request->image2 != $oldimg2){

            $oldimgurl = public_path('upload/img/').$oldimg;
            if(file_exists($oldimgurl)){
                unlink($oldimgurl);
            }
            //Save New Image and data
            $extension = explode('/', mime_content_type($request->image))[1];
            $imageName = 'lc'.uniqid().'.'.$extension;
            \Image::make($request->image)->resize(405, 340)->save(public_path('upload/img/').$imageName);

            $lc = ShopSetting::find($request->id);
            $lc->url = $request->btnurl;
            $lc->option1 = $request->title;
            $lc->option2 = $request->btntext;
            $lc->text = $request->desc;
            $lc->img = $imageName;
            $lc->save();


            $oldimgurl2 = public_path('upload/img/').$oldimg2;
            if(file_exists($oldimgurl2)){
                unlink($oldimgurl2);
            }
            //Save New Image and data
            $extension2 = explode('/', mime_content_type($request->image2))[1];
            $imageName2 = 'lc'.uniqid().'.'.$extension2;
            \Image::make($request->image2)->resize(595, 340)->save(public_path('upload/img/').$imageName2);

            $lc = ShopSetting::find($request->id2);
            $lc->url = $request->btnurl2;
            $lc->option1 = $request->title2;
            $lc->option2 = $request->btntext2;
            $lc->text = $request->desc2;
            $lc->img = $imageName2;
            $lc->save();
        }

        //If only change in Image One
        if($request->image != $oldimg){

            $oldimgurl = public_path('upload/img/').$oldimg;
            if(file_exists($oldimgurl)){
                unlink($oldimgurl);
            }
            //Save New Image and data
            $extension = explode('/', mime_content_type($request->image))[1];
            $imageName = 'lc'.uniqid().'.'.$extension;
            \Image::make($request->image)->resize(405, 340)->save(public_path('upload/img/').$imageName);

            $lc = ShopSetting::find($request->id);
            $lc->url = $request->btnurl;
            $lc->option1 = $request->title;
            $lc->option2 = $request->btntext;
            $lc->text = $request->desc;
            $lc->img = $imageName;
            $lc->save();

            $lc = ShopSetting::find($request->id2);
            $lc->url = $request->btnurl2;
            $lc->option1 = $request->title2;
            $lc->option2 = $request->btntext2;
            $lc->text = $request->desc2;
            $lc->save();
        }
        //If only change in Image Two
        if($request->image2 != $oldimg2){

            $lc = ShopSetting::find($request->id);
            $lc->url = $request->btnurl;
            $lc->option1 = $request->title;
            $lc->option2 = $request->btntext;
            $lc->text = $request->desc;
            $lc->save();


            $oldimgurl2 = public_path('upload/img/').$oldimg2;
            if(file_exists($oldimgurl2)){
                unlink($oldimgurl2);
            }
            //Save New Image and data
            $extension2 = explode('/', mime_content_type($request->image2))[1];
            $imageName2 = 'lc'.uniqid().'.'.$extension2;
            \Image::make($request->image2)->resize(595, 340)->save(public_path('upload/img/').$imageName2);

            $lc = ShopSetting::find($request->id2);
            $lc->url = $request->btnurl2;
            $lc->option1 = $request->title2;
            $lc->option2 = $request->btntext2;
            $lc->text = $request->desc2;
            $lc->img = $imageName2;
            $lc->save();
        }
    }

    public function shoplogoset(Request $request){
        $request->validate([
            'favicon'   => 'required',
            'shop_logo'   => 'required',
        ]);

        $favicon = ShopSetting::where('option_name', 'favicon')->first()->img;
        $shop_logo = ShopSetting::where('option_name', 'shop_logo')->first()->img;

        if($request->favicon != $favicon){

            $oldfaviconUrl = public_path('upload/img/').$favicon;
            if(file_exists($oldfaviconUrl)){
                unlink($oldfaviconUrl);
            }

            //Save New Image and data
            $favext = explode('/', mime_content_type($request->favicon))[1];
            $favName = 'lc'.uniqid().'.'.$favext;
            \Image::make($request->favicon)->save(public_path('upload/img/').$favName);

            $updatefavicon = ShopSetting::where('option_name', 'favicon')->first();
            $updatefavicon->img = $favName;
            $updatefavicon->save();
        }
        
        if($request->shop_logo != $shop_logo){

            $oldshop_logoUrl = public_path('upload/img/').$shop_logo;
            if(file_exists($oldshop_logoUrl)){
                unlink($oldshop_logoUrl);
            }

            //Save New Image and data
            $shop_logoext = explode('/', mime_content_type($request->shop_logo))[1];
            $shop_logoName = 'lc'.uniqid().'.'.$shop_logoext;
            \Image::make($request->favicon)->save(public_path('upload/img/').$shop_logoName);

            $updateshop_logo = ShopSetting::where('option_name', 'favicon')->first();
            $updateshop_logo->img = $shop_logoName;
            $updateshop_logo->save();
        }

    }




}
