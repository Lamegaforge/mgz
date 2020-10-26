<?php

namespace App\Http\Controllers\Api;

use Response;
use DateTime;
use App\Models\Clip;
use App\Repositories\ClipRepository;
use App\Repositories\CardRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateClipRequest;

class AdminController extends Controller
{
    public function clipUpdate(UpdateClipRequest $request)
    {
        $clip = $this->retrieveClip($request);

        $attributes = $request->validated();

        $attributes = $this->prepareStateAttributes($attributes);
        $attributes = $this->prepareCardAttributes($attributes);

        $clip->update($attributes);

        return Response::json([
            'timestamp' => (new DateTime())->getTimestamp(),
            'attributes' => $attributes,
        ], 200);
    }

    protected function retrieveClip(UpdateClipRequest $request): Clip
    {
        return app(ClipRepository::class)
            ->where('slug', $request->hook)
            ->orWhere('id', $request->hook)
            ->first();
    }

    protected function prepareStateAttributes(array $attributes): array
    {
        if (! isset($attributes['state'])) {
            return $attributes;
        }

        if ($attributes['state'] == 'active') {
            $attributes['approved_at'] = (new DateTime())->format('Y-m-d');
        }

        return $attributes;
    }

    protected function prepareCardAttributes(array $attributes): array
    {
        if (! isset($attributes['card'])) {
            return $attributes;
        }

        $card = app(CardRepository::class)
            ->where('slug', $attributes['card'])
            ->orWhere('id', $attributes['card'])
            ->firstOrFail();

        $attributes['card_id'] = $card->id;

        unset($attributes['card']);

        return $attributes;
    }
}
