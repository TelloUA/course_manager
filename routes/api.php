<?php

use App\Http\Controllers\ApiCourseController;
use App\Http\Controllers\ApiGroupController;
use App\Http\Controllers\ApiStudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$version = 'v1';

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

Route::get($version . '/students', [ApiStudentController::class, 'list']);
Route::get($version . '/students/{id}', [ApiStudentController::class, 'one']);
Route::post($version . '/students', [ApiStudentController::class, 'add']);
Route::delete($version . '/students/{id}', [ApiStudentController::class, 'delete']);
Route::delete($version . '/students/{id}/remove-group', [ApiStudentController::class, 'removeGroup']);

Route::get($version . '/groups', [ApiGroupController::class, 'list']);
Route::get($version . '/groups/{id}', [ApiGroupController::class, 'one']);
Route::post($version . '/groups/{id}/add-student', [ApiGroupController::class, 'addStudent']);

Route::get($version . '/courses', [ApiCourseController::class, 'list']);
Route::get($version . '/courses/{id}', [ApiCourseController::class, 'one']);
Route::post($version . '/courses/{id}/add-student', [ApiCourseController::class, 'addStudent']);
Route::post($version . '/courses/{id}/remove-student', [ApiCourseController::class, 'removeStudent']);
