<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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

Route::group(['middleware' => 'auth:sanctum'], function(){
    //All secure URL's

    //For a User
    Route::put("userUpdate",[UserController::class,'update']);

    Route::get("Getuser",[UserController::class,'Getuser']); 

});

      //for a user
Route::post("userSignup",[UserController::class,'userRegister']);

Route::post("userSignin",[UserController::class,'login']);
