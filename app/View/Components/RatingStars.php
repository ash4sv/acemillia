<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RatingStars extends Component
{
    public float $rating;
    public string $ulclass;

    /**
     * Create a new component instance.
     */
    public function __construct($rating = 0, $ulclass = 'rating')
    {
        $this->rating = floatval($rating);
        $this->ulclass = $ulclass;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.rating-stars');
    }
}
