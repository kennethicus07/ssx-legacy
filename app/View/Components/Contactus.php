<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Contactus extends Component
{
    public $title;
    public $subtitle;
    public $details;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $subtitle, $details)
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->details = $details;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
       return view('components.contact-us');
    }
}
