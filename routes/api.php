<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('login','AuthController@login');
Route::Post('register','AuthController@register');

Route::middleware('auth:api')->group(function(){
    Route::get('user','AuthController@details');
    Route::get('logout','AuthController@logout');
    Route::apiResource('post' , 'PostController');
    Route::apiResource('post/{post}/comment' , 'CommentController');
});