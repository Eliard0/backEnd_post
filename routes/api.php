<?php

use App\Http\Controllers\PostsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/posts', [PostsController::class, "index"]);
Route::post('/create/post', [PostsController::class, "store"]);
Route::get('search/post/{id}', [PostsController::class, "searchPost"]);
Route::delete('/delete/{id}', [PostsController::class, "destroy"]);
Route::put('editar/post/{id}', [PostsController::class, "updatePost"]);