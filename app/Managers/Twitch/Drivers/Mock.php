<?php

namespace App\Managers\Twitch\Drivers;

use App\Managers\Twitch\Contracts\Driver;

class Mock implements Driver
{
    public function getLastClips(): array
    {
        return [
            //
        ];
    }

    public function getLastVideos(int $limit = 100, int $offset = 0): array
    {
        return [
            [
                'title' => 'video title',
                'game' => 'Dino Crisis 2',
                'created_at' => '2020-01-01',
            ],
            [
                'title' => 'video title',
                'game' => '',
                'created_at' => '2020-01-02',
            ],
            [
                'title' => 'video title',
                'game' => 'Horizon Zero Dawn',
                'created_at' => '2020-01-03',
            ],
            [
                'title' => 'video title',
                'game' => 'Horizon Zero Dawn',
                'created_at' => '2020-01-04',
            ],
        ];
    }

    public function get(string $slug): array
    {
        return [
            //
        ];
    }    
}