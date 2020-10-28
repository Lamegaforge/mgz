<?php

namespace Database\Factories;

use App\Models\Achievement;
use Illuminate\Database\Eloquent\Factories\Factory;

class AchievementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Achievement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->unique()->sentence($nbWords = 4, $variableNbWords = true),
            'slug' => $this->faker->unique()->slug(),
            'description' => 'blablabla',
            'secret' => false,
            'points' => 100,
        ];
    }
}
