<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request){
        if($request->format() == 'html'){
             return view('layouts.backend_app');
        }
        $user = User::with('role')->where('role_id', '!=', 0)->orderBy('id', 'desc')->get();
        return response()->json($user);
     }
     public function store(Request $request){
         $this->validate($request, [
             'full_name' => 'required',
             'email' => 'required|email',
             'password' => 'required',
             'role_id' => 'required',
         ]);
         $user = new User();
         $user->full_name = $request->full_name;
         $user->email = $request->email;
         $user->password = Hash::make($request->password);
         $user->role_id = $request->role_id;
         $user->save();
         return response()->json([
             'success' => 'User stored'
         ], 200);

     }
     public function update(Request $request, $id){
         $user = User::find($id);
         $this->validate($request, [
            'full_name' => 'required',
            'email' => 'required|email',
            'role_id' => 'required',
        ]);
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->save();
         return response()->json([
             'success' => 'User updated'
         ], 200);
     }
     public function destroy($id){
         $user = User::find($id);
         $user->delete();
         return response()->json([
             'success' => 'User Deleted successfully'
         ], 200);
     }
}
