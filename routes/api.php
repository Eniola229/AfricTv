<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Controllers\Api\V1\NewPasswordController;
use App\Http\Controllers\Api\V1\UserCardDetails;
use App\Http\Controllers\Api\V1\Feedback;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');

//Open Route
Route::post('register', [ApiController::class, 'register']);
Route::post("login", [ApiController::class, "login"]);
Route::post('forgot_password', [NewPasswordController::class, 'forgotPassword']);
Route::post('reset_password', [NewPasswordController::class, 'resetPassword']);
Route::post('feedback', [Feedback::class, 'feedback']);



//Protected Route 
Route::group([
    "middleware" => ["auth:api"]
], function(){
    Route::post("payment", [ApiController::class, "payment"]);
    Route::get("profile", [ApiController::class, "profile"]);
    Route::get("logout", [ApiController::class, "logout"]);
    Route::put("updateprofile/{id}", [ApiController::class, "updateprofile"]);
    Route::post("carddetails", [UserCardDetails::class, "carddetails"]);
});
