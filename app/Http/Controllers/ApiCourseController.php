<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseListResource;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Models\Group;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;

class ApiCourseController extends Controller
{
    public function list(): JsonResource
    {
        $courses = Course::all();
        return CourseListResource::collection($courses);
    }

    public function one(Request $request): JsonResource
    {
        $course = Course::findOrFail($request->id);
        return CourseResource::make($course);
    }

    public function addStudent(Request $request): JsonResponse
    {
        if (!$course = Course::find($request->id)) {
            return response()->json(['errors' => 'No such course'], 422);
        }

        $validator = Validator::make($request->all(), [
            'studentId' => 'required|exists:students,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $student = Student::find($request->input('studentId'));

        if (!$student->courses()->find($course->id)) {
            $student->courses()->attach($course);
        }

        return response()->json([], 204);
    }

    public function removeStudent(Request $request): JsonResponse
    {
        if (!$course = Course::find($request->id)) {
            return response()->json(['errors' => 'No such course'], 422);
        }

        $validator = Validator::make($request->all(), [
            'studentId' => 'required|exists:students,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $student = Student::find($request->input('studentId'));

        $student->courses()->detach($course);

        return response()->json([], 204);
    }

}
