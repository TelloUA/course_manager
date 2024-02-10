<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::factory(200)->create();

        foreach (Student::all() as $student) {
            $student->courses()->attach($this->getCourses());
        }
    }

    private function getCourses()
    {
        $count = rand(0, 3);
        $ids = [];

        for ($i = 0; $i < $count; $i++) {
            $ids[] = rand(1, Course::all()->count());
        }

        return Course::whereIn('id', array_unique($ids))->get();
    }
}
