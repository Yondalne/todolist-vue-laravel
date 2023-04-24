<?php

use App\Http\Controllers\SignController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
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
Route::post("/register", [SignController::class, "register"]);
Route::post("/login", [SignController::class, "login"]);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/completeTask/{id}', [TaskController::class, "completeTask"]);
    Route::resource('/task', TaskController::class);
    Route::post("/user", [UserController::class, "update"]);
});
// Route::delete("/imageDelete", [UserController::class, "deleteImage"]);
