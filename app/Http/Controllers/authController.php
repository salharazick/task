<?php

namespace App\Http\Controllers;

use App\Http\Requests\registerRequest;
use App\Models\customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class authController extends Controller
{
    function register(registerRequest $request)
    {
          
        $validator = Validator::make($request->all(), $request->rules());

        
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
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
        $user = customer::where(['email'=>$request->email])->first();

        if(!$user || !Hash::check($request->password,$user->password))
        {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
        else
        {
            return response()->json(['message' => 'Login successful'], 200);
        }
            
     

    }

}