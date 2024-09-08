<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\StudentCourseController;
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
Route::get('courses/{id}/creator', [CourseController::class, 'getCreator']);
Route::middleware('auth:sanctum')->get('/signin-with-token', [UserController::class, 'signinWithToken']);



Route::post('/auth/logout', [UserController::class, 'logout'])->middleware('auth:api');
Route::apiResource('courses', CourseController::class);
Route::apiResource('internships', InternshipController::class);
Route::apiResource('courses', CourseController::class);

Route::post('/invite', [InvitationController::class, 'invite']);
Route::get('/student/{student_id}/invitations', [InvitationController::class, 'getStudentInvitations']);
Route::post('/join-course', [StudentCourseController::class, 'joinCourse']);
Route::get('/students/{id}/courses', [StudentCourseController::class, 'getStudentCourses']);

