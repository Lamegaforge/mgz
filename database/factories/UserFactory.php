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
            'tracking_id' => $this->faker->unique()->numberBetween(1000, 100000),
            'login' => $this->faker->name,
            'display_name' => $this->faker->name,
            'description' => $this->faker->words($nb = 6, $asText = true),
            'autoplay' => false,
            'profile_image_url' => $this->faker->imageUrl($width = 640, $height = 480, 'cats'),
            'banner_image_slug' => 'banner_image_slug',
            'email' => $this->faker->unique()->safeEmail,
            'youtube' => 'lamegaforge',
            'instagram' => 'lamegaforge',
            'twitter' => 'LaMegaforge',
        ];
    }
}
