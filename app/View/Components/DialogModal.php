<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DialogModal extends Component
{
    public $focusInput;

    public function __construct($focusInput = null)
    {
        $this->focusInput = $focusInput;
    }

    public function render()
    {
        return view('components.dialog-modal');
    }
}
