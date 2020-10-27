<?php

namespace App\Http\Requests\Api;

use DateTime;
use App\Repositories\CardRepository;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClipRequest extends FormRequest
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
            'hook' => 'required',
            'title' => 'string',
            'state' => 'string|in:active,waiting,rejected',
            'card' => 'string',
            'approved_at' => 'date',
            'card_id' => 'integer',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->prepareStateAttributes();
        $this->prepareCardAttributes();
    }

    protected function prepareStateAttributes(): void
    {
        $state = $this->state ?? null;

        if ($state != 'active') {
            return;
        }

        $this->merge([
            'approved_at' => (new DateTime())->format('Y-m-d'),
        ]);
    }

    protected function prepareCardAttributes(): void
    {
        if (! $this->card) {
            return;
        }

        $card = app(CardRepository::class)
            ->where('slug', $this->card)
            ->orWhere('id', $this->card)
            ->firstOrFail();

        $this->merge([
            'card_id' => $card->id,
        ]);

        $this->card = null;
    }
}
