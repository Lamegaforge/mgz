<?php

namespace App\Services;

use DB;
use stdclass;
use App\Models\Card;

class CardSniffer
{
    public function retrieve(string $name): ?Card
    {
        $results = $this->lookPotentialCard($name);

        if (! $results) {
            return null;
        }

        return Card::find($results->id);
    }

    protected function lookPotentialCard(string $name): ?stdclass
    {
        return DB::table('cards')
            ->select('cards.id', DB::raw('COUNT(clips.id) AS clips'))
            ->join('clips', 'clips.card_id', '=', 'cards.id')
            ->where('clips.game', 'LIKE', '%' . $name . '%')
            ->orWhere('cards.game', $name)
            ->groupBy('cards.id')
            ->orderByDesc('clips')
            ->first();
    }
}