<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Form extends Component
{
    public $title;
    public $maxWidth;

    public function __construct($title = '', $maxWidth = 'lg')
    {
        $this->title = $title;
        $this->maxWidth = $maxWidth;
    }

    public function render()
    {
        return view('components.form');
    }
} 