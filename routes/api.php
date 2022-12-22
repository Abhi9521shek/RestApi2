<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Authcontroller;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\Commentcontroller;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/register',[Authcontroller::class,'register']);
Route::post('/auth/login',[Authcontroller::class,'login']);
Route::get('/auth/user',[Authcontroller::class,'user'])->middleware('auth:sanctum');
Route::post('/blogs/create',[BlogController::class,'create']);
Route::get('/blogs/{id}',[BlogController::class,'details']);
Route::put('/blogs/{id}/update',[BlogController::class,'update'])->middleware('auth:sanctum');
Route::delete('/blogs/{id}/delete',[BlogController::class,'delete'])->middleware('auth:sanctum');
Route::post('/blogs/{blog_id}/comments/create',[Commentcontroller::class,'create'])->middleware('auth:sanctum');