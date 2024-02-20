<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class StudentsController extends Controller
{
    public function list(Request $request): View
    {
        $groups = Group::all();
        $selectedGroup = $request->input('group_id');

        $query = Student::query();

        if ($selectedGroup) {
            $query->whereHas('group', function ($query) use ($selectedGroup) {
                $query->where('id', $selectedGroup);
            });
        }

        $students = $query->paginate(20);

        return view('students', [
            'students' => $students,
            'groups' => $groups,
            'selectedGroup' => $selectedGroup,
        ]);
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

    public function delete(Request $request): RedirectResponse
    {
        $student = Student::findOrFail($request->id);
        $name = $student->getFullName();
        $student->courses()->detach();
        $student->delete();

        Session::flash('success', "Student $name deleted successfully.");

        return redirect()->route('students');
    }
}
