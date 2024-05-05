<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ApiController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');

//Open Route
Route::post('register', [ApiController::class, 'register']);
Route::post("login", [ApiController::class, "login"]);

//Protected Route 
Route::group([
    "middleware" => ["auth:api"]
], function(){
    Route::post("payment", [ApiController::class, "payment"]);
    Route::get("profile", [ApiController::class, "profile"]);
    Route::get("logout", [ApiController::class, "logout"]);
    Route::put("updateprofile/{id}", [ApiController::class, "updateprofile"]);
});
