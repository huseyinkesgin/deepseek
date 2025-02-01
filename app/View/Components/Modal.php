<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public $type;
    public $title;
    public $maxWidth;
    public $zIndex;

    public function __construct($type = 'form', $title = '', $maxWidth = '2xl', $zIndex = 'z-50')
    {
        $this->type = $type;
        $this->title = $title;
        $this->maxWidth = $maxWidth;
        $this->zIndex = $zIndex;
    }

    public function render()
    {
        return view('components.modal');
    }
}