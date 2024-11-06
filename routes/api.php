<?php

use App\Http\Controllers\PostsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/posts', [PostsController::class, "getAllPosts"]);
Route::post('/create/post', [PostsController::class, "createdPost"]);
Route::get('search/post/{id}', [PostsController::class, "searchPost"]);
Route::delete('/delete/{id}', [PostsController::class, "destroy"]);
Route::put('editar/post/{id}', [PostsController::class, "updatePost"]);


Route::fallback(function () {
    return response()->view('notFound', [], 404);
});