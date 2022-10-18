<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Block>
 */
class BlockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'year_level' => random_int(1, 4),
            'section' => random_int(1, 3),
            'user_id' => random_int(1, 10)
        ];
    }
}
