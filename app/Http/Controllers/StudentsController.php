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

    public function one(Request $request): View
    {
        $student = Student::find($request->id);
        return view('student', ['student' => $student]);
    }
}
