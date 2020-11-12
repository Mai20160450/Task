<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('Authuser', ['except' => ['register' , 'login' ,'logout']]);
    }
    public function register(Request $request){
        $this->validate($request ,[
            'name'=> "required|min:3",
            'email' => "required|email|unique:users",
            'password'=> "required|min:6",
            'password_confirmation' =>'required',
        ]);
        $request['password'] = bcrypt($request->password);
        $user = User::create($request->all());
        $token = $user->createToken('EnlightureAcademy')->accessToken;

        return response()->json(['token' => $token],200);

    }

    public function login(Request $request){
        $credentials =[
            'email' => $request->email,
            'password' => $request->password,
        ];

        if(auth()->attempt($credentials)){
            $token = auth()->user()->createToken('EnlightureAcademy')->accessToken;
            return response()->json(['token' => $token],200);

        }else{
            return response()->json(['error' => 'UnAuthorized']);
        }
    }

    public function logout()
    {
        
        auth()->user()->token()->revoke();
        return response()->json(['message' => 'Successfully logged out'],200);
    }

    public function details(){
        return response()->json(['user' => auth()->user()] , 200);
    }
}
