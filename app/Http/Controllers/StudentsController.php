<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
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

    public function add(): View
    {
        $groups = Group::all();

        return view('student-add', ['groups' => $groups]);
    }

    public function save(Request $request): RedirectResponse
    {
        $request->validate([
            'firstName' => 'required|max:255',
            'lastName' => 'required|max:255',
            'groupId' => 'required|exists:groups,id',
        ]);

        $student = new Student();
        $student->first_name = $request->firstName;
        $student->last_name = $request->lastName;
        $student->group_id = $request->groupId;
        $student->save();

        return redirect('/students');
    }
}
