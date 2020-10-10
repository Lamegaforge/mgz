<?php

namespace Database\Seeders;

use App\Models\Clip;
use App\Models\Card;
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

            Clip::factory()
                ->times(15)
                ->create([
                    'card_id' => $card->id,
                ]);
        });
    }
}
