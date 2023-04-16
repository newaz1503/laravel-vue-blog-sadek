<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(Request $request){

        if(!Auth::check() && $request->path() != 'admin/login'){
            return redirect('/admin/login');
        }
        if(!Auth::check() && $request->path() == 'admin/login'){
            return view('layouts.backend_app');
        }
        if(Auth::user()->user_type == 'user'){
            return redirect('/admin/login');
        }
        if(Auth::check() && $request->path() == 'admin/login'){
            return redirect('/admin/dashboard');
        }
        $user = Auth::user();
        return $this->checkPermission($user, $request);

        return view('layouts.backend_app');
    }
    public function checkPermission($user, $request){
         $permission = json_decode($user->role->permission);
        if(!$permission){
            return view('layouts.backend_app');
        }
        $hasPermission = false;
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

    public function logout(){
        Auth::logout();
        return response()->json([
            'msg' => 'logout'
        ]);
    }
}
