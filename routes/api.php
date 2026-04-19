<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

// route bawaan (biarkan)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// TAMBAHKAN DI BAWAH INI
Route::apiResource('posts', PostController::class);
