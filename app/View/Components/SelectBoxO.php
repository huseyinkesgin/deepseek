<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SelectBoxO extends Component
{
    public $label;
    public $name;
    public $options;
    public $selected;
    public $placeholder;
    public $required;
    public $disabled;

    public function __construct(
        $label = null,
        $name = null,
        $options = [],
        $selected = null,
        $placeholder = 'Seçiniz',
        $required = false,
        $disabled = false
    ) {
        $this->label = $label;
        $this->name = $name;
        $this->options = $options;
        $this->selected = $selected;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->disabled = $disabled;
    }

    public function render()
    {
        return view('components.select-box-o');
    }
} 