<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupListResource;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;

class ApiGroupController extends Controller
{
    public function list(): JsonResource
    {
        $groups = Group::all();
        return GroupListResource::collection($groups);
    }

    public function one(Request $request): JsonResource
    {
        $group = Group::findOrFail($request->id);
        return GroupResource::make($group);
    }

    public function addStudent(Request $request): JsonResponse
    {
        if (!$group = Group::find($request->id)) {
            return response()->json(['errors' => 'No such group'], 422);
        }

        $validator = Validator::make($request->all(), [
            'studentId' => 'required|exists:students,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $student = Student::find($request->input('studentId'));
        $student->group()->associate($group);
        $student->save();

        return response()->json([], 204);
    }
}
