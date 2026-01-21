<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Authentication Routes with rate limiting
Route::middleware(['throttle:5,1'])->group(function () {
    Route::post('/signup', [AuthController::class, 'register']);
    Route::post('/signin', [AuthController::class, 'login']);
    Route::post('/signout', [AuthController::class, 'logout'])
        ->middleware('auth:sanctum');
});
