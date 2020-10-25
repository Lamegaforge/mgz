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
        $achievements = [
            [
                'title' => 'Valerie Damidot',
                'slug' => 'valerie_damidot',
                'points' => 100,
            ],
            [
                'title' => 'Five active clips',
                'slug' => 'five_active_clips',
                'points' => 500,
            ],
            [
                'title' => 'Ten active clips',
                'slug' => 'ten_active_clips',
                'points' => 1000,
            ],
            [
                'title' => 'Fifteen active clips',
                'slug' => 'fifteen_active_clips',
                'points' => 1500,
            ],
            [
                'title' => 'Twenty active clips',
                'slug' => 'twenty_active_clips',
                'points' => 2000,
            ],
        ];

        array_map(function ($achievement) {
            Achievement::factory()->create($achievement);
        }, $achievements);
    }
}
