<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\Attributes\Title;

class CustomerIndex extends Component
{
    #[Title('Müşteriler')]
    public function render()
    {
        return view('livewire.customer.customer-index');
    }
}
