<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $images = array_diff(scandir(dirname(__DIR__, 2) . '/public/img/', 1), array('.', '..'));
        return [
            'title' => $this->faker->text(50),
            'description' => $this->faker->paragraph(),
            'thumbnail' => $this->faker->randomElement($images),
            'status' => $this->faker->randomElement([0,1])
        ];
    }
}
