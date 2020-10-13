<?php

namespace App\Http\Requests\Web;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class ConsumeOauthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'state' => 'required|string',
            'code' => 'required|string',
        ];
    }
}
