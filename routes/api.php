<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/all",[PostController::class,"index"]);
Route::post("/post",[PostController::class,"store"]);
Route::delete("/delete-post/{id}",[PostController::class,"destroy"]);
Route::put("/update/{id}",[PostController::class,"Update"]);



