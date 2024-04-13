<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Student;

class TestApiStudentSeeder extends AbstractTestSeeder
{
    public function run(): void
    {
        $this->groups = [
            ['name' => 'RR-01']
        ];
        $this->courses = [
            [
                'name' => 'math',
                'description' => 'some algebra and geometry',
            ]
        ];
        $this->students = [
            [
                'firstName' => 'Name1',
                'lastName' => 'Surname1',
                'groupId' => null,
            ],
            [
                'firstName' => 'Name2',
                'lastName' => 'Surname2',
                'groupId' => 1,
            ],
            [
                'firstName' => 'Name3',
                'lastName' => 'Surname3',
                'groupId' => 1,
            ],
        ];
        $this->setupModels();
        Student::find(1)->courses()->attach(Course::find(1));
    }
}
