<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseListResource;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
}
