<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Clip;
use App\Models\Card;
use App\Models\Comment;
use App\Models\Notification;
use Illuminate\Database\Seeder;
use Database\Seeders\AchievementSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AchievementSeeder::class,
        ]);

        $this->feed();
    }

    protected function feed(): void
    {
        $cards = Card::factory()
            ->times(6)
            ->create();

        $cards->map(function ($card) {

            $clips = Clip::factory()
                ->times(8)
                ->create([
                    'card_id' => $card->id,
                ]);

            $clips->map(function ($clip) {

                Comment::factory()
                    ->times(5)
                    ->has(Comment::factory()->count(3), 'children')
                    ->create([
                        'clip_id' => $clip->id,
                    ]);

                Notification::factory()
                    ->times(10)
                    ->create([
                        'user_id' => $clip->user->id,
                    ]);
            });
        });
    }
}
