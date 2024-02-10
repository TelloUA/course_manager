<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentsController extends Controller
{
    public function list(): View
    {
        $students = Student::all();
        return view('students', ['students' => $students]);
    }
}
