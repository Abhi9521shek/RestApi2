<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Blog; 
use Auth;

class BlogController extends Controller
{
    public function create(Request $request){
        $validator = validator::make($request->all(),[
            'title'=>'required|max:250',
            'post'=>'required',
            // 'short_description'=>'required',
            // 'long_description'=>'required',
            'user_id'=>'required'
        ]);

        if ($validator->fails()){
            return response()->json([
                'message'=>'validation errors',
                'errors'=>$validator->messages()
            ],422);
        }

       $blog= Blog::create([
            'title'=>$request->title,
            // 'short_description'=>$request->short_description,
            // 'long_description'=>$request->long_description,
            'post'=>$request->post,
           // 'user_id'=>auth()->user()->id,
            'user_id'=>$request->user_id
       ]);

       $blog->load('user');
       return response()->json([
        'message'=>'Blog successfully created',
        'data'=>$blog
       ],200);
    }

    public function details ($id){
        $blog=Blog::with(['user'])->where('id',$id)->first();
        if($blog){
            return response()->json([
                'message'=>'Blog successfully fetched',
                'data'=>$blog
               ],200);
        }else{
            return response()->json([
                'message'=>'no blog found',
               // 'data'=>$blog
               ],400);
        }
    }

    public function update ($id,Request $request){
            $blog=Blog::with(['user'])->where('id',$id)->first();
            if($blog){
                    if($blog->user_id==$request->user()->id){
                            $validator = validator::make($request->all(),[
                                'title'=>'required|max:250',
                                // 'short_description'=>'required',
                                // 'long_description'=>'required',
                                'post'=>'required',
                                'user_id'=>'required'
                            ]);
                    
                            if ($validator->fails()){
                                return response()->json([
                                    'message'=>'validation errors',
                                    'errors'=>$validator->messages()
                                ],422);
                            }
                            $blog->update([
                                'title'=>$request->title,
                                // 'short_description'=>$request->short_description,
                                // 'long_description'=>$request->long_description,
                                'post'=>$request->post,
                                'user_id'=>$request->user_id
                            ]);
                            return response()->json([
                                'message'=>'Blog Successfully updated',
                                'data'=>$blog
                            ],200);
                        } else{
                        return response()->json([
                            'message'=>'Access denied'
                        ],403);
                }
            }else{
                return response()->json([
                    'message'=>'no blog found',
                // 'data'=>$blog
                ],400);
            }
    }

    public function delete($id,Request $request){
        
        
            $blog=Blog::where('id',$id)->first();
            if($blog){
                 if($blog->user_id==$request->user()->id){
                    
                    
    
                    $blog->delete();
                    return response()->json([
                        'message'=>'Blog Successfull deleted',
                        'data'=>$blog
                    ],200);
    
    
                 }else{
                    return response()->json([
                        'message'=>'Access denide',
                        
                    ],403);
                 }
            }else{
                return response()->json([
                    'message'=>'Blog not found',
                    
                ],400);
            }

            
        
    }

      
     
     
}
