<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;

class CategoryController extends Controller
{
    public function index(Request $request){
        if($request->format() == 'html'){
             return view('layouts.backend_app');
        }
        $category = Category::orderBy('id', 'desc')->get();
        return response()->json($category);
     }
     public function store(Request $request){
         $this->validate($request, [
             'name' => 'required|unique:categories',
             'image' => 'required',
         ]);
         $category = new Category();
         $category->name = $request->name;
         $category->slug = Str::slug($request->name);
         if($request->image){
            $string_position = strpos($request->image, ';');
            $sub_str = substr($request->image, 0, $string_position);
            $extension = explode('/', $sub_str)[1];
            $imageName = time().'.'.$extension;
            $img = Image::make($request->image)->resize(600, 600);
            $image_path = public_path()."/uploads/category/";
            $img->save($image_path.$imageName);
        }
         $category->image = $imageName;
         $category->save();
         return response()->json([
             'success' => 'Category stored'
         ], 200);

     }
     public function update(Request $request, $id){
         $category = Category::find($id);
         $this->validate($request, [
             'name' => 'required|unique:categories,name,'.$category->id ,
         ]);

         $category->name = $request->name;
         $category->slug = Str::slug($request->name);
         if($request->image !=  $category->image){
            $string_position = strpos($request->image, ';');
            $sub_str = substr($request->image, 0, $string_position);
            $extension = explode('/', $sub_str)[1];
            $imageName = time().'.'.$extension;
            $img = Image::make($request->image)->resize(600, 600);
            $image_path = public_path()."/uploads/category/";
            $path = public_path()."/uploads/category/".$category->image;
            if($path){
                @unlink($path);
            }
            $img->save($image_path.$imageName);

        }else{
            $imageName =$category->image;
        }
         $category->image = $imageName;
         $category->save();
         return response()->json([
             'success' => 'Category updated'
         ], 200);
     }
     public function destroy($id){
         $category = Category::find($id);
         $path =public_path()."/uploads/category/".$category->image;
         if($path){
            @unlink($path);
         }
         $category->delete();
         return response()->json([
             'success' => 'Deleted successfully'
         ], 200);
     }
}
