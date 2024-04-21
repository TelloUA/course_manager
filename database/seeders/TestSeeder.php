<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Group;
use App\Models\Student;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    public function run(): void
    {
        Group::create([
            'name' => 'HH-10',
        ]);

        $courses = [
            ['math', 'some algebra and geometry'],
            ['art', 'some modern and pop-art'],
        ];

        foreach ($courses as $data) {
            Course::create([
                'name' => $data[0],
                'description' => $data[1],
            ]);
        }

        $students = [
            ['Andrii', 'Tello', 1],
            ['Yevhen', 'Bro', null],
        ];

        foreach ($students as $data) {
            Student::create([
                'first_name' => $data[0],
                'last_name' => $data[1],
                'group_id' => $data[2],
            ]);
        }

        Student::find(1)->courses()->attach(Course::find(1));
        Student::find(2)->courses()->attach(Course::find(2));
    }
}
