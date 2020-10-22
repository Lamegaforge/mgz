<?php

namespace App\Http\Responses;

use DateTime;
use Response;
use Illuminate\Contracts\Support\Responsable;

class GenericApiResponse implements Responsable
{
    public function __construct($status = 200)
    {
        $this->status = $status; 
    }

    public function toResponse($request)
    {
        return Response::json([
            'timestamp' => (new DateTime())->getTimestamp(),
        ], $this->status);
    }
}
