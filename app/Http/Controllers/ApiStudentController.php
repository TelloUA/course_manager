<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;

class ApiStudentController extends Controller
{
    public function list(Request $request)
    {
        $selectedGroup = $request->input('group_id');
        $query = Student::query();

        if ($selectedGroup) {
            $query->whereHas('group', function ($query) use ($selectedGroup) {
                $query->where('id', $selectedGroup);
            });
        }
        $query->orderBy('first_name');
        $students = $query->paginate(20);
        return StudentResource::collection($students);
    }

    public function one(Request $request)
    {
        $student = Student::findOrFail($request->id);
        return StudentResource::make($student);
    }

}
