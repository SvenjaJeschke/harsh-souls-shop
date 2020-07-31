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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:api']], static function() {
    Route::get('/products', 'ProductController@index');
    Route::get('/product/{product}', 'ProductController@show');
    Route::put('/product/{product}', 'ProductController@update');
    Route::get('/product/{product}/cover-image', 'ProductController@getCoverImage');
    Route::put('/product/cover-image/{image}', 'ProductController@setCoverImage');
    Route::put('/product/cover-image/{image}/unset', 'ProductController@unsetCoverImage');

    Route::post('/images/{product}', 'ImageController@store');
    Route::delete('/images/{image}', 'ImageController@destroy');
    Route::get('/images/{image}/download', 'ImageController@show');

    Route::get('/keywords/product/{product}', 'KeywordController@index');
    Route::post('/keywords/product/{product}', 'KeywordController@store');
    Route::delete('/keywords/{keyword}/product/{product}', 'KeywordController@destroy');

    Route::get('/versions/product/{product}', 'VersionController@index');
    Route::post('/version/product/{product}', 'VersionController@store');
    Route::delete('/version/{version}', 'VersionController@destroy');
    Route::put('/version/{version}', 'VersionController@update');
});

Route::get('/categories', 'CategoryController@index');
