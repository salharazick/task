<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class authController extends Controller
{
    function register(Request $request)
    {
        $validator= validator::make( $request->all(),
        [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:customers',
            'password' => 'required|min:5',

        ],

        );
        
        if($validator->fails())
        {
            return response()->json($validator->errors());
        }

        else{

        $customer = new customer();

        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->password = Hash::make($request->password);

        $customer->save();

        return response()->json(
            ['message' => 'user registered successfully']
        );
        }
    }

    function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::customer();
    
            return response()->json(['login success'], 200);
        } else {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    }

}