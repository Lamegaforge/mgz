<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Clip;
use App\Models\Card;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $cards = Card::factory()->times(20)->create();

        $cards->map(function ($card) {

            $clips = Clip::factory()
                ->times(8)
                ->create([
                    'card_id' => $card->id,
                ]);

            $clips->map(function ($clip) {

                Comment::factory()
                    ->times(5)
                    ->create([
                        'user_id' => User::inRandomOrder()->first(),
                        'clip_id' => $clip->id,
                    ]);
            });
        });
    }
}
