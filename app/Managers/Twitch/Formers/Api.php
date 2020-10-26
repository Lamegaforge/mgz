<?php

namespace App\Managers\Twitch\Formers;

use App\Managers\Twitch\Entities\Clip;
use App\Managers\Twitch\Contracts\Former;

class Api implements Former
{
    public function clips(array $clips) :array
    {
        return array_map(function($clip) {
            return $this->clip($clip);
        }, $clips);
    }

    public function clip(array $clip): array
    {
        return [
            'slug' => $clip['slug'] ?? null,
            'tracking_id' => $clip['tracking_id'] ?? null,
            'title' => $clip['title'] ?? null,
            'url' => $clip['url'] ?? null,
            'game' => $clip['game'] ?? null,
            'views' => $clip['views'] ?? null,
            'thumbnail' => $clip['thumbnails']['medium'] ?? null,
            'created_at' => $clip['created_at'] ?? null,
            'curator' => [
                'tracking_id' => $clip['curator']['id'] ?? null,    
                'name' => $clip['curator']['name'] ?? null,
                'display_name' => $clip['curator']['display_name'] ?? null,    
                'channel_url' => $clip['curator']['channel_url'] ?? null,    
                'logo' => $clip['curator']['logo'] ?? null,    
            ],
        ];
    }

    public function videos(array $videos) :array
    {
        return array_map(function($video) {
            return $this->video($video);
        }, $videos);
    }

    public function video(array $video): array
    {
        return [
            'title' => $video['title'],
            'game' => $video['game'],
            'created_at' => $video['created_at'],
        ];
    }
}
