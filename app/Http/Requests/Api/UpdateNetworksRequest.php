<?php

namespace App\Http\Requests\Api;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNetworksRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'youtube' => 'nullable|string',
            'twitch' => 'nullable|string',
            'instagram' => 'nullable|string',
            'twitter' => 'nullable|string',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'youtube' => $this->youtube ?? null,
            'twitch' => $this->twitch ?? null,
            'instagram' => $this->instagram ?? null,
            'twitter' => $this->twitter ?? null,
        ]);
    }
}
