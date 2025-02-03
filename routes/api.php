<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\NewsController;
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
//USER AUTHENTICATION
Route::post('/auth/register', [UserController::class, 'createUser']);
Route::post('/auth/login', [UserController::class, 'loginUser']);
Route::middleware('auth:sanctum')->get('/signin-with-token', [UserController::class, 'signinWithToken']);
Route::post('/auth/logout', [UserController::class, 'logout'])->middleware('auth:api');

//USERS
Route::get('/user/getUsers', [UserController::class, 'index']);

//COURSES
Route::get('courses/{id}/creator', [CourseController::class, 'getCreator']);
Route::apiResource('courses', CourseController::class);
Route::post('/join-course', [StudentCourseController::class, 'joinCourse']);
Route::get('/students/{id}/courses', [StudentCourseController::class, 'getStudentCourses']);
Route::get('/professors/{professorId}/students', [StudentCourseController::class, 'getStudentsForProfessor']);
Route::post('/leave-course', [StudentCourseController::class, 'leaveCourse']);

//INVITATIONS
Route::put('/invitations/{invitationId}/status', [InvitationController::class, 'updateInvitationStatus']);
Route::post('/invite', [InvitationController::class, 'invite']);
Route::get('/student/{student_id}/invitations', [InvitationController::class, 'getStudentInvitations']);
Route::put('/invitation/{invitationId}', [InvitationController::class, 'updateInvitationStatus']);

//INTERNSHIPS
Route::apiResource('internships', InternshipController::class);
Route::get('professor/{professor_id}/internships', [InvitationController::class, 'getProfessorInternships']);

//COMPANIES
Route::get('/companies', [CompanyController::class, 'index']);
Route::get('/companies/{id}', [CompanyController::class, 'show']);
Route::post('/companies', [CompanyController::class, 'store']);
Route::put('/companies/{id}', [CompanyController::class, 'update']);
Route::delete('/companies/{id}', [CompanyController::class, 'destroy']);

//NEWS
Route::get('news', [NewsController::class, 'index']);
Route::post('news', [NewsController::class, 'store']);
Route::get('news/{id}', [NewsController::class, 'show']);
Route::put('news/{id}', [NewsController::class, 'update']);
Route::delete('news/{id}', [NewsController::class, 'destroy']);


Route::post('/apply-internship', [InvitationController::class, 'applyForInternship']);
Route::get('/student-internships', [InvitationController::class, 'getStudentCreatedInternships']);
Route::get('/applications', [InvitationController::class, 'getAllApplications']);
Route::post('/internships/{internshipId}/join', [InternshipController::class, 'joinInternship']);
Route::get('internships/{internshipId}/users', [InternshipController::class, 'getUsers']);
Route::get('users/internships', [InternshipController::class, 'getAllUsers']);

