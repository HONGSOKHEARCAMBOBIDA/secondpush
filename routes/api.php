<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; // Correctly imported

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/example', function () {
    return "Hello world";
});

Route::post('/create-user', [UserController::class, 'store']); // Use UserController with uppercase 'C'
Route::post('/get-user',[UserController::class , 'index']);
Route::post('update-user',[UserController::class,'update']);