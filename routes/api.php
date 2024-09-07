<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\InternshipController;
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

Route::post('/auth/register', [UserController::class, 'createUser']);
Route::post('/auth/login', [UserController::class, 'loginUser']);
Route::get('/user/getUsers', [UserController::class, 'index']);
Route::middleware('auth:sanctum')->get('/signin-with-token', [UserController::class, 'signinWithToken']);


Route::post('/auth/logout', [UserController::class, 'logout'])->middleware('auth:api');

Route::apiResource('internships', InternshipController::class);

