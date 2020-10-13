<?php

namespace Database\Factories;

use App\Models\Card;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Card::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $variableNbWords = true;

        return [
            'title' => $this->faker->unique()->sentence($nbWords = 4, $variableNbWords),
            'short_title' => $this->faker->unique()->sentence($nbWords = 2, $variableNbWords),
            'media_folder' => null,
            'description' => $this->faker->unique()->sentence($nbWords = 10, $variableNbWords),
        ];
    }
}
