<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $names = static::names();
        return [
            'first_name' => $names[0],
            'last_name' => $names[1],
            'group_id' => static::groupId(),
        ];
    }

    public static function names(): array
    {
        $faker = \Faker\Factory::create();
        $firstName = $faker->firstName();
        $secondName = $faker->lastName();
        return [$firstName, $secondName];
    }

    public static function groupId(): int|null
    {
        $number = rand(0, 10);
        return $number === 0 ? null : $number;
    }
}
