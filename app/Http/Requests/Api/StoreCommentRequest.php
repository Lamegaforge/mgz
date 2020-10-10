<?php

namespace App\Http\Requests\Api;

use Auth;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreCommentRequest extends FormRequest
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
            'clip_id' => 'required|filled|integer|exists:clips,id',
            'parent_comment_id' => [
                Rule::exists('comments', 'id')->where(function ($query) {
                    $query->whereNull('parent_comment_id');
                }),
            ],
            'content' => 'required|filled|string',
        ];
    }
}
