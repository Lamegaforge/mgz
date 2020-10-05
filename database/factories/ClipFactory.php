<?php

namespace Database\Factories;

use App\Models\Clip;
use App\Models\User;
use App\Models\Card;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClipFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Clip::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tracking_id' => $this->faker->unique()->numberBetween(1000, 10000),
            'user_id' => User::factory()->create(),
            'card_id' => Card::factory()->create(),
            'slug' => $this->faker->slug,
            'title' => $this->faker->unique()->sentence($nbWords = 6, $variableNbWords = true),
            'thumbnail' => $this->faker->imageUrl($width = 640, $height = 480, 'cats'),
            'url' => $this->faker->unique()->url,
            'active' => true,
            'views' => $this->faker->numberBetween($min = 100, $max = 500),
            'approved_at' => $this->faker->dateTimeInInterval($startDate = '-30 years', $interval = '+ 5 days'),
        ];
    }
}
