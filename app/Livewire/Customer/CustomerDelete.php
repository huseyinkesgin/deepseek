<?php

namespace App\Livewire\Customer;

use App\Models\Customer;
use Livewire\Component;
use Livewire\Attributes\On;

class CustomerDelete extends Component
{
    public $showModal = false;
    public $customerId;
    public $name;
    public $surname;
    public $code;

    #[On('showCustomerDeleteModal')]
    public function show($data)
    {
        if (isset($data['id'])) {
            $customer = Customer::find($data['id']);
            $this->customerId = $customer->id;
            $this->name = $customer->name;
            $this->surname = $customer->surname;
            $this->code = $customer->code;
            $this->showModal = true;
        }
    }

    public function delete()
    {
        $customer = Customer::find($this->customerId);
        $customer->delete();

        $this->dispatch('customer-deleted');
        $this->close();
    }

    public function close()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.customer.customer-delete');
    }
}
