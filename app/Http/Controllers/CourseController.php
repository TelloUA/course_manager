<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function list(): View
    {
        $courses = Course::all();
        return view('courses', ['courses' => $courses]);
    }

    public function one(Request $request): View
    {
        $course = Course::findOrFail($request->id);

        $students = Student::whereDoesntHave('courses', function (Builder $query) use ($course) {
            $query->where('courses.id', '=', $course->id);
        })->orderBy('first_name')->get();

        return view('course', ['course' => $course, 'students' => $students]);
    }

    public function addStudent(Request $request): RedirectResponse
    {
        $request->validate([
            'studentId' => 'required|exists:students,id',
        ]);

        if (!$course = Course::find($request->id)) {
            return redirect('courses');
        }

        $student = Student::find($request->studentId);

        if (!$student->courses()->find($course->id)) {
            $student->courses()->attach($course);
        }

        return redirect()->route('course', [$course->id]);
    }

    public function removeStudent(Request $request): RedirectResponse
    {
        $request->validate([
            'studentId' => 'required|exists:students,id',
        ]);

        $student = Student::findOrFail($request->studentId);
        $course = Course::find($request->id);

        $student->courses()->detach($course);

        return redirect()->route('course', [$course->id]);
    }
}
