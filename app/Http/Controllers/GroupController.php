<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class GroupController extends Controller
{
    public function list(Request $request): View
    {
        $groups = Group::all();
        $countStudents = $request->input('count_students');

        if ($countStudents) {
            $groups = Group::has('students', '<=', $countStudents)->get();
        }

        return view('groups', ['groups' => $groups, 'count' => $countStudents]);
    }

    public function one(Request $request): View
    {
        $freeStudents = Student::where('group_id', null)->orderBy('first_name')->get();
        $group = Group::find($request->id);
        return view('group', ['group' => $group, 'students' => $freeStudents]);
    }

    public function addStudent(Request $request): RedirectResponse
    {
        $request->validate([
            'studentId' => 'required|exists:students,id',
        ]);

        $group = Group::findOrFail($request->id);
        $student = Student::findOrFail($request->studentId);

        $student->group_id = $group->id;
        $student->save();

        return redirect()->route('group', [$group->id]);
    }

    public function removeStudent(Request $request): RedirectResponse
    {
        $student = Student::findOrFail($request->studentId);
        $student->group_id = null;
        $student->save();

        return redirect()->route('group', [$request->id]);
    }
}
