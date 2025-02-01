<?php

namespace App\Livewire\Company;

use App\Models\Company;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class CompanyTable extends Component
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
        $firstCompany = $this->getFilteredCompanies()->first();
        if($firstCompany) {
            $this->selectedRow = $firstCompany->id;
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

    protected function getFilteredCompanies()
    {
        return Company::search($this->search)
            ->active($this->activeFilter !== '' ? $this->activeFilter : null)
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function openEditModal($id = null)
    {
        $id = $id ?? $this->selectedRow;
        if($id) {
            $this->dispatch('showCompanyEditModal', ['id' => $id]);
        }
    }

    public function openDeleteModal($id = null)
    {
        $id = $id ?? $this->selectedRow;
        if($id) {
            $this->dispatch('showCompanyDeleteModal', ['id' => $id]);
        }
    }

    public function handleKeyDown($data)
    {
        if(!$this->selectedRow) return;

        $companies = $this->getFilteredCompanies()->items();
        $currentIndex = collect($companies)->search(function($company) {
            return $company->id === $this->selectedRow;
        });

        switch($data['key']) {
            case 'ArrowUp':
                if($currentIndex > 0) {
                    $this->selectedRow = $companies[$currentIndex - 1]->id;
                }
                break;
            case 'ArrowDown':
                if($currentIndex < count($companies) - 1) {
                    $this->selectedRow = $companies[$currentIndex + 1]->id;
                }
                break;
            case 'Enter':
                $this->openEditModal();
                break;
        }
    }

    #[On('company-updated')]
    #[On('company-created')]
    #[On('company-deleted')]
    public function refreshData()
    {
        $this->selectedRow = null;
    }

    public function render()
    {
        return view('livewire.company.company-table', [
            'companies' => $this->getFilteredCompanies()
        ]);
    }
} 