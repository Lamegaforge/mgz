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
        $games = $this->getGames();

        return [
            'title' => $this->faker->unique()->sentence($nbWords = 4, $variableNbWords),
            'slug' => $this->faker->unique()->slug(),
            'description' => $this->faker->unique()->sentence($nbWords = 10, $variableNbWords),
            'game' => $this->faker->randomElement($games),
        ];
    }

    protected function getGames(): array
    {
        return [
            'S.T.A.L.K.E.R.',
            'Horizon Zero Dawn',
            'Dino Crisis 2',
            'DOOM',
            'River City Girls',
            'Total War Shogun 2',
        ];
    }
}
