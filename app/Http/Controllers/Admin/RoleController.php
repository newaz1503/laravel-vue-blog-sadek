<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function index(Request $request){
        if($request->format() == 'html'){
             return view('layouts.backend_app');
        }
        $role = Role::orderBy('id', 'desc')->get();
        return response()->json($role);
     }
     public function store(Request $request){
         $this->validate($request, [
             'name' => 'required|unique:roles',
         ]);
         $role = new Role();
         $role->name = $request->name;
         $role->save();
         return response()->json([
             'success' => 'Role stored'
         ], 200);
     }
     public function update(Request $request, $id){
         $role = Role::find($id);
         $this->validate($request, [
             'name' => 'required|unique:roles,name,'.$role->id ,
         ]);
         $role->name = $request->name;
         $role->save();
         return response()->json([
             'success' => 'Role updated'
         ], 200);
     }
     public function destroy($id){
         $role = Role::find($id);
         $role->delete();
         return response()->json([
             'success' => 'Deleted successfully'
         ], 200);
     }

     public function assign_role(Request $request){
        $this->validate($request, [
            'permission' => 'required'
        ]);
       Role::where('id', $request->id)->update([
            'permission' =>$request->permission
       ]);
       return response()->json([
            'success' => 'permission assign successfully'
        ], 200);
     }
}
