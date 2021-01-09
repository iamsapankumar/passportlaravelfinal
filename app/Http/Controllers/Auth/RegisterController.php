<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request){

        $newuser =$request->all();
        $validator = Validator::make($request->all(),[
            'name'=>"required",
            'email'=>'required|email|unique:users',
            'password'=>'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'error'=>$validator->errors()
            ]);
        }
        
        $newuser['password']=Hash::make($newuser['password']);
        $user = User::create($newuser);
        $success['token']=$user->createToken('AppName')->accessToken;
        return response()->json([
            'success'=>$success,
            'message' => 'Successfull created user!'

        ],200);
    }
  

  
}
