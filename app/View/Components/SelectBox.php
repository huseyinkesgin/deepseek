<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SelectBox extends Component
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
        $this->options = $this->formatOptions($options);
        $this->selected = $selected;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->disabled = $disabled;
    }

    protected function formatOptions($options)
    {
        // Eğer options boş array ise ve name 'status' ise
        if (empty($options) && $this->name === 'status') {
            return [
                '' => 'Seçiniz',
                '1' => 'Aktif',
                '0' => 'Pasif'
            ];
        }

        return $options;
    }

    public function render()
    {
        return view('components.select-box');
    }
}
