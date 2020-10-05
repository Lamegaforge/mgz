<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tracking_id' => $this->faker->unique()->numberBetween(1000, 10000),
            'login' => $this->faker->name,
            'display_name' => $this->faker->name,
            'profile_image_url' => $this->faker->imageUrl($width = 640, $height = 480, 'cats'),
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}
