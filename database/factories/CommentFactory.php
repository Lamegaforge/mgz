<?php

namespace Database\Factories;

use App\Models\Clip;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

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
            'content' => $this->faker->paragraph($nbSentences = 3, $variableNbSentences = true),
            'active' => true,
            'approved_at' => $this->faker->dateTimeInInterval($startDate = '-30 years', $interval = '+ 5 days'),
        ];
    }
}
