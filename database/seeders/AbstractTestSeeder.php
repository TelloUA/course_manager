<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Group;
use App\Models\Student;
use Illuminate\Database\Seeder;

class AbstractTestSeeder extends Seeder
{
    protected array $students = [];
    protected array $groups = [];
    protected array $courses = [];

    protected function setupModels(): void
    {
        $this->setupGroups();
        $this->setupCourses();
        $this->setupStudents();
    }

    private function setupGroups(): void
    {
        foreach ($this->groups as $group) {
            Group::create([
                'name' => $group['name'],
            ]);
        }
    }

    private function setupCourses(): void
    {
        foreach ($this->courses as $course) {
            Course::create([
                'name' => $course['name'],
                'description' => $course['description'],
            ]);
        }
    }

    private function setupStudents(): void
    {
        foreach ($this->students as $student) {
            Student::create([
                'first_name' => $student['firstName'],
                'last_name' => $student['lastName'],
                'group_id' => $student['groupId'],
            ]);
        }
    }
}
