<?php

namespace Database\Factories;

use App\Models\Clip;
use App\Models\User;
use App\Models\Favorite;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Favorite::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'clip_id' => Clip::factory(),
            'user_id' => User::factory(),
        ];
    }
}
