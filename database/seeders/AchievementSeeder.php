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
            ['valerie_damidot', 500, 'Valerie Damidot'],

            ['ten_active_clips', 500, 'Ten active clips'],
            ['thirty_active_clips', 500, 'Thirty active clips'],
            ['fifty_active_clips', 500, 'Fifty active clips'],
            ['seventy_active_clips', 500, 'Seventy active clips'],
            ['hundred_active_clips', 500, 'Hundred active clips'],
            ['one_hundred_fifty_active_clips', 500, 'One Hundred Fifty active clips'],

            ['thousand_views_all_clips', 500, 'Thousand views all clips'],
            ['two_thousand_views_all_clips', 500, 'Two thousand views all clips'],
            ['three_thousand_views_all_clips', 500, 'Three thousand views all clips'],
        ];

        array_map(function ($achievement) {

            $attributes = [
                'title' => $achievement[2],
                'slug' => $achievement[0],
                'points' => $achievement[1],
            ];

            Achievement::firstOrCreate($attributes);

        }, $achievements);
    }
}

// SELECT user_id,
//   SUM(views) AS total_views
// FROM clips
// GROUP BY user_id
// ORDER BY SUM(views) DESC;

// SELECT user_id, COUNT(clips.id) AS total_clips
// FROM clips
// GROUP BY user_id
// ORDER BY COUNT(clips.id) DESC;