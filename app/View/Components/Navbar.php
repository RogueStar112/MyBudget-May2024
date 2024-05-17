<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Navbar extends Component
{
    public $brandName;

    public $brandColor;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    
    public function __construct($brandName, $brandColor)
    {
        //
        $this->brandName = $brandName;
        $this->brandColor = $brandColor;
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
