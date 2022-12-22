<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Hash;

class Authcontroller extends Controller
{
    public function register (Request $request){
        $validator=Validator::make($request->all(),[
            'phone' => 'required','digits:10','unique:users',        
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|max:100',
            'confirm_password'=>'required|same:password'
        ]);

        if ($validator->fails()){
            return response()->json([
                'message'=>'Validations fails',
                'errors'=>$validator->errors()
            ],422);
        }

        $user=User::create([
            'phone'=>$request->phone,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);

        return response()->json([
            'message'=>'Registration successfull',
             'data'=>$user
        ],200);

        
    }

    public function login(Request $request){
        $validator=Validator::make($request->all(),[ 
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if ($validator->fails()){
            return response()->json([
                'message'=>'Validations fails',
                'errors'=>$validator->errors()
            ],422);
        }
        $user =User::where('email',$request->email)->first();
            
            if($user){
                if(Hash::check($request->password,$user->password,)){
                    $token=$user->createToken('auth-token')->plainTextToken;

                    return response()->json([
                        'message'=>'Login Successfull',
                        'token'=>$token,
                        'data'=>$user
                    ],200);


                }else{
                    return response()->json([
                        'message'=>'Incorrect credential',
                    ],400);
                }
            }else{
                return response()->json([
                    'message'=>'Incorrect credential',
                ],400);
            }
    }

    public function user(Request $request){
        return response()->json([
            'message'=>'User  successfully  fetched',
             'data'=>$request->user()
        ],200);
    }
     
}
