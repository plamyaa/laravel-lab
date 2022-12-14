<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function create(){
        return view('auth/registration');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:App\Models\User',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
            'role_id' => 2,
        ]);

        $token = $user->createToken('myAppToken');
        return response()->json([
            'user' => $user, 
            'token' => $token,
        ]);
    }

    public function login(){
        return view('auth.signin');
    }

    public function customLogin(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = [
            'email'=>request('email'),
            'password'=>request('password'),
        ];
        if(Auth::attempt($credentials)){
            $token = auth()->user()->createToken('myAppToken');
            return response($token);
        }
        return response('Bad login, 401');
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        return response('Logout user');
    }
}