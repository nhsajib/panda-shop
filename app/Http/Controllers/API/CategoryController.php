<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Http\Resources\AdminApiCollection;
use App\Http\Resources\AdminApiResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new AdminApiCollection(Category::with('topcategory')->paginate(5));
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
            'topcategory_id' => 'required',
            'name' => 'required|unique:top_categories|min:3|max:32',
            'description' => 'required|min:10|max:120',
            'img' => 'required',
        ]);

        if($request->img){
            //get file extention
            $extension = explode('/', mime_content_type($request->img))[1];
            //Generate a Unique name with file extention
            $imageName = 'cat'.uniqid().'.'.$extension;
            //convert base64 to image and upload to folder
            \Image::make($request->img)->resize(180, 180)->save(public_path('upload/img/').$imageName);
        }

        $topcategory = New Category;
        $topcategory->topcategory_id = $request->topcategory_id;
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
        $catimg = Category::find($id)->img;

        if(strcmp($catimg, $request->img) !== 0){
            $request->validate([
            'topcategory_id' => 'required',
            'name' => 'required|Min:3|Max:32|unique:top_categories,name,'.$id,
            'description' => 'required|min:10|max:120',
            'img' => 'required',
            ]);

            if($request->img){
                //get file extention
                $extension = explode('/', mime_content_type($request->img))[1];
                //Generate a Unique name with file extention
                $imageName = 'cat'.uniqid().'.'.$extension;
                //convert base64 to image and upload to folder
                \Image::make($request->img)->resize(180, 180)->save(public_path('upload/img/').$imageName);
            }

            $oldimgurl = public_path('upload/img/').$catimg;
            if(file_exists($oldimgurl)){
                unlink($oldimgurl);
            }

            $topcategory = Category::find($id);
            $topcategory->topcategory_id = $request->topcategory_id;
            $topcategory->name = $request->name;
            $topcategory->description = $request->description;
            $topcategory->img = $imageName;
            $topcategory->save();

        }else{
            $request->validate([
            'topcategory_id' => 'required',
            'name' => 'required|Min:3|Max:32|unique:top_categories,name,'.$id,
            'description' => 'required|min:10|max:120',
            'img' => 'required',
            ]);

            $topcategory = Category::find($id);
            $topcategory->topcategory_id = $request->topcategory_id;
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

    }

    public function search($query){
        return new AdminApiCollection(Category::where('name', 'LIKE', "%$query%")->with('topcategory')->paginate(5));
    }

    public function getall()
    {
        return new AdminApiCollection(Category::all());
    }

}
