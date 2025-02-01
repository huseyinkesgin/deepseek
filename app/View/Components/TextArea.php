<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TextArea extends Component
{
    public $label;
    public $name;
    public $value;
    public $placeholder;
    public $rows;
    public $required;
    public $disabled;

    public function __construct(
        $label = null,
        $name = null,
        $value = null,
        $placeholder = null,
        $rows = 3,
        $required = false,
        $disabled = false
    ) {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->rows = $rows;
        $this->required = $required;
        $this->disabled = $disabled;
    }

    public function render()
    {
        return view('components.text-area');
    }
}
