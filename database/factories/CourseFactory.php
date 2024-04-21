<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    public const COURSES = [
        'math',
        'history',
        'geography',
        'physics',
        'biology',
        'chemistry',
        'literature',
        'language',
        'music',
        'art',
    ];

    private static int $pointer = 0;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => self::nextCourse(),
            'description' => self::desc(),
        ];
    }

    private static function nextCourse(): string
    {
        $course = self::COURSES[self::$pointer];
        self::$pointer++;
        return $course;
    }

    private static function desc(): string
    {
        $faker = \Faker\Factory::create();
        return $faker->text(60);
    }
}
