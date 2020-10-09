<?php

namespace App\Http\Requests\Api;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class SearchClipsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'card_id' => 'integer',
            'search' => 'string',
        ];
    }
}