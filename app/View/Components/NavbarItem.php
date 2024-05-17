<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NavbarItem extends Component
{   

    /**
     * The link/url in action..
     *
     * @var string
     */
    public $url;

    /**
     * The title of the button
     *
     * @var string
     */
    public $title;


     /**
     * The background color.
     *
     * @var string
     */
    public $color;

    /**
     * The icon to use.
     *
     * @var string
     */
    public $icon;


    /**
     * Create a new component instance.
     *
     * @param string $url
     * @param string $title
     * @param string $color
     * @param string $icon
     * @return void
     */
    public function __construct($url, $title, $color, $icon)
    {   
        $this->url = $url;
        $this->title = $title;
        $this->color = $color;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.navbar-item');
    }
}
