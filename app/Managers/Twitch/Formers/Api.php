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
            'slug' => $clip['slug'],
            'tracking_id' => $clip['tracking_id'],
            'title' => $clip['title'],
            'url' => $clip['url'],
            'game' => $clip['game'],
            'views' => $clip['views'],
            'thumbnail' => $clip['thumbnails']['medium'],
            'created_at' => $clip['created_at'],
            'curator' => [
                'tracking_id' => $clip['curator']['id'],    
                'name' => $clip['curator']['name'],
                'display_name' => $clip['curator']['display_name'],    
                'channel_url' => $clip['curator']['channel_url'],    
                'logo' => $clip['curator']['logo'],    
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
