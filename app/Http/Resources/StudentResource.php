<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $group = $this->group;
        $groupArray = [];
        if ($group) {
            $groupArray = [
                'id' => $group->id,
                'name' => $group->name,
            ];
        }

        $courses = $this->courses;
        $courseArray = [];
        foreach ($courses as $course) {
            $courseArray[] = [
                'id' => $course->id,
                'name' => $course->name,
            ];
        }

        return [
            'id' => $this->id,
            'name' => $this->getFullName(),
            'group' => $groupArray,
            'courses' => $courseArray,
        ];
    }
}
