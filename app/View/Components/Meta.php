<?php

namespace App\View\Components;

use App\Models\Clip;
use Illuminate\View\Component;
use App\Services\IframeService;

class Meta extends Component
{
    public $clip;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Clip $clip)
    {
        $this->clip = $clip;
    }

    public function embedUrl(): string
    {
        return app(IframeService::class)->url($this->clip);
    }

    public function title(): string
    {
        return  'Megasaurus - ' . $this->clip->title;
    }

    public function description(): string
    {
        $card = $this->clip->card;

        return $card->title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.meta');
    }
}
