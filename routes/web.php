<?php

use App\Http\Controllers\StudentsController;
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

Route::get('/students', [StudentsController::class, 'list'])->name('students');
Route::get('/student/{id}', [StudentsController::class, 'one'])->name('student');
Route::get('/student-add', [StudentsController::class, 'add'])->name('studentAdd');
Route::post('/student-save', [StudentsController::class, 'save'])->name('studentSave');
Route::delete('/student/{id}', [StudentsController::class, 'delete'])->name('studentDelete');
