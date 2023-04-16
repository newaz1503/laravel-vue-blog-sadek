<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    public function index(Request $request){

       if($request->format() == 'html'){
            return view('layouts.backend_app');
       }
       $tag = Tag::orderBy('id', 'desc')->get();
       $user = Auth::user();

       return response()->json($tag);
    //    return $this->checkPermission($user, $request);

    }
    public function checkPermission($user, $request){
       $permission = json_decode($user->role->permission[0]);

       $hasPermission = true;
       if(!$permission){
        return view('layouts.backend_app');
       }
        foreach($permission as $p){
            if($p->name == $request->path()){
                if($p->read){
                    $hasPermission = true;
                }
            }
        }
        if($hasPermission){
            return view('layouts.backend_app');
        }
        return view('errors.404');
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:tags',
        ]);
        $tag = new Tag();
        $tag->name = $request->name;
        $tag->slug = Str::slug($request->name);
        $tag->save();
        return response()->json([
            'success' => 'Tag stored'
        ], 200);

    }
    public function update(Request $request, $id){
        $tag = Tag::find($id);
        $this->validate($request, [
            'name' => 'required|unique:tags,name,'.$tag->id ,
        ]);
        $tag->name = $request->name;
        $tag->slug = Str::slug($request->name);
        $tag->save();
        return response()->json([
            'success' => 'Tag updated'
        ], 200);
    }
    public function destroy($id){
        $tag = Tag::find($id);
        $tag->delete();
        return response()->json([
            'success' => 'Deleted successfully'
        ], 200);
    }
}
