<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Blog;


class Commentcontroller extends Controller
{
    public function create($blog_id,Request $request)
    {
        $blog=Blog::where('id',$blog_id)->first();
        if($blog){
            $validator = Validator::make($request->all() ,[
                'message'=> 'required',
                 
            ]);
    
            if ($validator->fails()){
                return response()->json([
                    'message'=>'Validation errors',
                    'errors'=>$validator->messages()
                ],422);
            } 
            $comment=Comment::create([
              'message'=>$request->message,
              'blog_id'=>$blog->id,
              'user_id'=>auth()->user()->id,
            ]);
            $comment->load('user');

            return response()->json([
                'message'=>'Comment Successfull created',
                'data'=>$comment
            ],200);

        }else{
            return response()->json([
                'message'=>'Blog not found',
                
            ],400);
        }
    }
}
