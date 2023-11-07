<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Api;
use App\Http\Controllers\Api\CatigoriesController;
use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Middleware\AssignGuard;

use Tymon\JWTAuth\Facades\JWTAuth;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware'=>['api','checkpassword']], function(){


    Route::post('get-main-catigories',[CatigoriesController::class,'index']);  //env password does not work if method is get?
    Route::post('store-new-catigory',[CatigoriesController::class,'store']);
    Route::post('category', [CatigoriesController::class,'update']);
    Route::get('delete-catigory/{id}',[CatigoriesController::class,'delete']);

    Route::group(['prefix' => 'admin'], function(){
        Route::post('login',[AuthController::class,'login']);
        Route::post('logout',[AuthController::class,'logout'])->middleware('auth.guard:admin-api');
        //invalid token security side
    });

});
