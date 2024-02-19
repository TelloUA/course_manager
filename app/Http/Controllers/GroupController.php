<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
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
}
