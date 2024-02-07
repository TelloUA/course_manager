<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => static::newGroupName(),
        ];
    }

    protected static function newGroupName(): string
    {
        $string = strtoupper(Str::random(2));
        $number = rand(10, 99);
        return  $string . '-' . $number;
    }
}
