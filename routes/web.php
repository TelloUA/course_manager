<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/students', [StudentController::class, 'list'])->name('students');
Route::get('/student/{id}', [StudentController::class, 'one'])->name('student');
Route::get('/student-add', [StudentController::class, 'add'])->name('studentAdd');
Route::post('/student-save', [StudentController::class, 'save'])->name('studentSave');
Route::delete('/student/{id}', [StudentController::class, 'delete'])->name('studentDelete');

Route::get('/groups', [GroupController::class, 'list'])->name('groups');
Route::get('/group/{id}', [GroupController::class, 'one'])->name('group');
Route::post('/group/{id}/add-student', [GroupController::class, 'addStudent'])->name('groupAddStudent');
Route::delete('/group/{id}/remove-student', [GroupController::class, 'removeStudent'])->name('groupRemoveStudent');

Route::get('/courses', [CourseController::class, 'list'])->name('courses');
Route::get('/courses/{id}', [CourseController::class, 'one'])->name('course');
Route::post('/courses/{id}/add-student', [CourseController::class, 'addStudent'])->name('courseAddStudent');
Route::delete('/courses/{id}/remove-student', [CourseController::class, 'removeStudent'])->name('courseRemoveStudent');
