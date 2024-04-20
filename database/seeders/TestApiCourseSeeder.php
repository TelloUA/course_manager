<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Student;

class TestApiCourseSeeder extends AbstractTestSeeder
{
    public function run(): void
    {
        $this->courses = [
            [
                'name' => 'math',
                'description' => 'some algebra and geometry',
            ],
            [
                'name' => 'literature',
                'description' => 'some good books',
            ],
            [
                'name' => 'geography',
                'description' => 'some info about lands',
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
                'groupId' => null,
            ],
            [
                'firstName' => 'Name3',
                'lastName' => 'Surname3',
                'groupId' => null,
            ],
        ];

        $this->setupModels();
        Student::find(1)->courses()->attach(Course::find(1));
        Student::find(2)->courses()->attach(Course::find(1));
        Student::find(2)->courses()->attach(Course::find(2));
    }
}
