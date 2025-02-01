<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TableButtons extends Component
{
    public $row;
    public $formComponent;

    public function __construct($row = null, $formComponent = null)
    {
        $this->row = $row;
        $this->formComponent = $formComponent; // 'DistrictForm', 'CityForm' gibi
    }

    public function render()
    {
        return view('components.table-buttons');
    }
}
