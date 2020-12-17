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

Route::group(['prefix' => 'post',  'middleware' => 'auth:sanctum'], function()
{
    Route::get('load_posts', 'App\Http\Controllers\PostController@load_posts');
    Route::post('upload', 'App\Http\Controllers\PostController@upload');
});
Route::post('auth_with_facebook', 'App\Http\Controllers\AuthController@auth_with_facebook');

