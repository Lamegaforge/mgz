<?php

namespace Database\Seeders;

use Config;
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
        $achievements = Config::get('achievements');

        array_map(function ($achievement) {
            Achievement::firstOrCreate($achievement);
        }, $achievements);
    }
}
