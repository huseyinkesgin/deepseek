<?php

namespace App\Livewire\Company;

use Livewire\Component;
use Livewire\Attributes\Title;

class CompanyIndex extends Component
{
    #[Title('Firmalar')]
    public function render()
    {
        return view('livewire.company.company-index');
    }
} 