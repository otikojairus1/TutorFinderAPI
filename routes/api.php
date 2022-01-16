<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/register', [\App\Http\Controllers\UserController::class, "store"]);
Route::post('/login', [\App\Http\Controllers\UserController::class, "login"]);
Route::get('/tutors', [\App\Http\Controllers\UserController::class, "allTutors"]);
Route::post('/add/review', [\App\Http\Controllers\UserController::class, "addReview"]);
Route::get('/reviews/{id}', [\App\Http\Controllers\UserController::class, "list_all_reviews"]);
Route::post('/update/profile/{id}', [\App\Http\Controllers\UserController::class, "update_profile"]);

