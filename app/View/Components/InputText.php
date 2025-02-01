<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InputText extends Component
{
    public $label;
    public $name;
    public $value;
    public $placeholder;
    public $icon;
    public $type;
    public $required;
    public $disabled;

    public function __construct(
        $label = null,
        $name = null,
        $value = null,
        $placeholder = null,
        $icon = null,
        $type = 'text',
        $required = false,
        $disabled = false
    ) {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->icon = $icon;
        $this->type = $type;
        $this->required = $required;
        $this->disabled = $disabled;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.input-text');
    }
}
