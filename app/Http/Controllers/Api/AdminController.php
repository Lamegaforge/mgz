<?php

namespace App\Http\Controllers\Api;

use Response;
use DateTime;
use App\Models\Clip;
use App\Repositories\ClipRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateClipRequest;

class AdminController extends Controller
{
    public function clipUpdate(UpdateClipRequest $request)
    {
        $clip = $this->retrieveClip($request);

        $attributes = $request->validated();

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
}
