<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\productController;
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

/*
* product routes
*
*/

Route::post('register',[authController::class,'register']);
Route::post('login',[authController::class,'login']);

/*
* product routes
*
*/

Route::get('products',[productController::class,'index']);
Route::post('product',[productController::class,'store']);
Route::get('product/{id}',[productController::class,'show']);
Route::put('product/{id}',[productController::class,'update']);
Route::delete('product/{id}',[productController::class,'destroy']);
Route::get('productc/count',[productController::class,'countProducts']);

/*
* category routes
*
*/

Route::get('categories',[categoryController::class,'index']);
Route::post('category',[categoryController::class,'store']);
Route::get('category/{id}',[categoryController::class,'show']);
Route::put('category/{id}',[categoryController::class,'update']);
Route::delete('category/{id}',[categoryController::class,'destroy']);