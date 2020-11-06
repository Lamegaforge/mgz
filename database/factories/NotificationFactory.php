<?php

namespace Database\Factories;

use DateTime;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Notification::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'content' => null,
            'readed_at' => null,
        ];
    }

    public function unread()
    {
        return $this->state(function (array $attributes) {
            return [
                'readed_at' => null,
            ];
        });
    }

    public function readed()
    {
        return $this->state(function (array $attributes) {
            return [
                'readed_at' => (new DateTime())->format('Y-m-d'),
            ];
        });
    }
}
