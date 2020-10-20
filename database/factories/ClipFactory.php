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
        $games = $this->getGames();

        return [
            'tracking_id' => $this->faker->unique()->numberBetween(1000, 100000),
            'user_id' => User::factory(),
            'card_id' => Card::factory(),
            'slug' => $this->faker->slug,
            'title' => $this->faker->unique()->sentence($nbWords = 6, $variableNbWords = true),
            'game' => $this->faker->randomElement($games),
            'thumbnail' => $this->faker->imageUrl($width = 640, $height = 480, 'cats'),
            'url' => $this->faker->unique()->url,
            'active' => true,
            'state' => 'active',
            'views' => $this->faker->numberBetween($min = 100, $max = 500),
            'approved_at' => $this->faker->dateTimeInInterval($startDate = '-30 years', $interval = '+ 5 days'),
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
