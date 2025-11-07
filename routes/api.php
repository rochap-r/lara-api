<?php

use App\Http\Controllers\Api\V1\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/hello', function () {
    return response()->json(['message' => 'Hello, World!']);
});

Route::group(['prefix' => 'v1'], function () {
    Route::get('/status', function () {
        return response()->json(['status' => 'API is working']);
    });

    Route::apiResource('posts', PostController::class);
});
