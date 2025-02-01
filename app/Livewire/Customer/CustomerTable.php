<?php

namespace App\Livewire\Customer;

use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class CustomerTable extends Component
{
    use WithPagination;

    public $selectedRow = null;
    public $search = '';
    public $activeFilter = '';
    public $perPage = 10;
    public $sortField = 'code';
    public $sortDirection = 'asc';

    protected $queryString = [
        'search' => ['except' => ''],
        'activeFilter' => ['except' => ''],
        'sortField' => ['except' => 'code'],
        'sortDirection' => ['except' => 'asc'],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->initializeSelection();
    }

    public function initializeSelection()
    {
        $firstCustomer = $this->getFilteredCustomers()->first();
        if($firstCustomer) {
            $this->selectedRow = $firstCustomer->id;
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
        $this->initializeSelection();
    }

    public function updatingActiveFilter()
    {
        $this->resetPage();
        $this->initializeSelection();
    }

    public function setSelectedRow($id)
    {
        $this->selectedRow = $id;
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    protected function getFilteredCustomers()
    {
        return Customer::query()
            ->with(['company', 'city', 'district', 'neighbourhood'])
            ->when($this->search, function($query) {
                $query->search($this->search);
            })
            ->active($this->activeFilter !== '' ? $this->activeFilter : null)
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function openEditModal($id = null)
    {
        $id = $id ?? $this->selectedRow;
        if($id) {
            $this->dispatch('showCustomerEditModal', ['id' => $id]);
        }
    }

    public function openDeleteModal($id = null)
    {
        $id = $id ?? $this->selectedRow;
        if($id) {
            $this->dispatch('showCustomerDeleteModal', ['id' => $id]);
        }
    }

    public function handleKeyDown($data)
    {
        if(!$this->selectedRow) return;

        $customers = $this->getFilteredCustomers()->items();
        $currentIndex = collect($customers)->search(function($customer) {
            return $customer->id === $this->selectedRow;
        });

        switch($data['key']) {
            case 'ArrowUp':
                if($currentIndex > 0) {
                    $this->selectedRow = $customers[$currentIndex - 1]->id;
                }
                break;
            case 'ArrowDown':
                if($currentIndex < count($customers) - 1) {
                    $this->selectedRow = $customers[$currentIndex + 1]->id;
                }
                break;
            case 'Enter':
                $this->openEditModal();
                break;
        }
    }

    #[On('customer-updated')]
    #[On('customer-created')]
    #[On('customer-deleted')]
    public function refreshData()
    {
        $this->selectedRow = null;
    }

    public function render()
    {
        return view('livewire.customer.customer-table', [
            'customers' => $this->getFilteredCustomers()
        ]);
    }
}
