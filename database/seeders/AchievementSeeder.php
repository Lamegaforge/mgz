<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Achievement::factory()->create([
            'title' => 'Valerie Damidot',
            'slug' => 'valerie_damidot',
            'points' => 100,
        ]);
    }
}
