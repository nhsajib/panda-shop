<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TopCategory;
use App\Http\Resources\AdminApiCollection;
use App\Http\Resources\AdminApiResource;


class TopCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new AdminApiCollection(TopCategory::paginate());
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
        'name' => 'required|unique:top_categories|min:3|max:32',
        'description' => 'required|min:10|max:120',
        'img' => 'required',
        ]);

        if($request->img){
            //get file extention
            $extension = explode('/', mime_content_type($request->img))[1];
            //Generate a Unique name with file extention
            $imageName = 'topcat'.uniqid().'.'.$extension;
            //convert base64 to image and upload to folder
            \Image::make($request->img)->resize(180, 180)->save(public_path('upload/img/').$imageName);
        }

        $topcategory = New TopCategory;
        $topcategory->name = $request->name;
        $topcategory->description = $request->description;
        $topcategory->img = $imageName;
        $topcategory->save();

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
        $topcatimg = TopCategory::find($id)->img;

        if(strcmp($topcatimg, $request->img) !== 0){
            $request->validate([
            'name' => 'required|Min:3|Max:32|unique:top_categories,name,'.$id,
            'description' => 'required|min:10|max:120',
            'img' => 'required',
            ]);

            if($request->img){
                //get file extention
                $extension = explode('/', mime_content_type($request->img))[1];
                //Generate a Unique name with file extention
                $imageName = 'topcat'.uniqid().'.'.$extension;
                //convert base64 to image and upload to folder
                \Image::make($request->img)->resize(180, 180)->save(public_path('upload/img/').$imageName);
            }

            $oldimgurl = public_path('upload/img/').$topcatimg;
            if(file_exists($oldimgurl)){
                unlink($oldimgurl);
            }

            $topcategory = TopCategory::find($id);
            $topcategory->name = $request->name;
            $topcategory->description = $request->description;
            $topcategory->img = $imageName;
            $topcategory->save();

        }else{
            $request->validate([
            'name' => 'required|Min:3|Max:32|unique:top_categories,name,'.$id,
            'description' => 'required|min:10|max:120',
            'img' => 'required',
            ]);

            $topcategory = TopCategory::find($id);
            $topcategory->name = $request->name;
            $topcategory->description = $request->description;
            $topcategory->img = $request->img;
            $topcategory->save();
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
        $category = TopCategory::find($id);

        $imgUrl = public_path('upload/img/').$category->img;
        if(file_exists($imgUrl)){
            unlink($imgUrl);
        }

        $category->delete();
    }
}
