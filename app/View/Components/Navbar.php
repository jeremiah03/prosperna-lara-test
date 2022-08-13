<?php

namespace App\View\Components;

use App\Models\Cart;
use Illuminate\View\Component;

class Navbar extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $item_count = 0;

    public function __construct()
    {
        if (auth()->check()) {
            $this->item_count = auth()->user()->cart->count();
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.navbar');
    }
}
