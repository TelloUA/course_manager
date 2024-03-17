<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;

class ApiStudentController extends Controller
{
    public function list(Request $request): JsonResource
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

    public function one(Request $request): JsonResource|JsonResponse
    {
        $student = Student::find($request->id);
        if (!$student) {
            return response()->json(['errors' => 'Not found'], 404);
        }
        return StudentResource::make($student);
    }

    public function add(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|max:255',
            'lastName' => 'required|max:255',
            'groupId' => 'required|exists:groups,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $student = new Student();
        $student->first_name = $request->input('firstName');
        $student->last_name = $request->input('lastName');
        $student->group_id = $request->input('groupId');
        $student->save();

        return response()->json(['studentId' => $student->id], 201);
    }

    public function delete(Request $request): JsonResponse
    {
        if (!$student = Student::find($request->id)) {
            return response()->json(['errors' => 'Student already deleted.'], 422);
        }

        $student->courses()->detach();
        $student->delete();
        return response()->json([], 204);
    }

    public function removeGroup(Request $request)
    {
        $validator = Validator::make(
            ['id' => $request->id],
            ['id' => 'required|exists:students,id'],
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $student = Student::find($request->id);
        $student->group()->dissociate();
        $student->save();

        return response()->json([], 204);
    }
}
