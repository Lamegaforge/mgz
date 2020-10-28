<?php

namespace App\Http\Requests\Api;

use Auth;
use App\Services\AuthorityService;
use Illuminate\Foundation\Http\FormRequest;

class RejectClipRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        $goal = AuthorityService::CAN_REJECT_CLIP;

        return app(AuthorityService::class)->can($user, $goal);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'clip_id' => 'required|filled|integer|exists:clips,id',
        ];
    }
}
