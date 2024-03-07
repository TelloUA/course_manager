<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupListResource;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
}
