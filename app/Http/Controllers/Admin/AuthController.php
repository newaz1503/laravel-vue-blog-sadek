<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){

        $this->validate($request, [
            'email' => 'bail|required|email',
            'password' => 'bail|required',
        ]);
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            if($user->role->isAdmin == 0){
                return back();
                return response()->json([
                    'msg' => 'Access denied'
                ]);
            }
        }else{
            return response()->json([
                'msg' => 'Not match'
            ], 401);
        }
    }
}
