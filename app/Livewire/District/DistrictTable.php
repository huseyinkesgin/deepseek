<?php

namespace App\Livewire\District;

use Livewire\Component;
use App\Models\District;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class DistrictTable extends Component
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
        'sortField' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->initializeSelection();
    }

    public function initializeSelection()
    {
        $firstDistrict = $this->getFilteredDistricts()->first();
        if($firstDistrict) {
            $this->selectedRow = $firstDistrict->id;
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

    protected function getFilteredDistricts()
    {
        return District::search($this->search)
            ->active($this->activeFilter !== '' ? $this->activeFilter : null)
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function openEditModal($id = null)
    {
        $id = $id ?? $this->selectedRow;
        if($id) {
            $this->dispatch('showDistrictEditModal', ['id' => $id]);
        }
    }

    public function openDeleteModal($id = null)
    {
        $id = $id ?? $this->selectedRow;
        if($id) {
            $this->dispatch('showDistrictDeleteModal', ['id' => $id]);
        }
    }

    public function handleKeyDown($data)
    {
        if(!$this->selectedRow) return;

        $districts = $this->getFilteredDistricts()->items();
        $currentIndex = collect($districts)->search(function($district) {
            return $district->id === $this->selectedRow;
        });

        switch($data['key']) {
            case 'ArrowUp':
                if($currentIndex > 0) {
                    $this->selectedRow = $districts[$currentIndex - 1]->id;
                }
                break;
            case 'ArrowDown':
                if($currentIndex < count($districts) - 1) {
                    $this->selectedRow = $districts[$currentIndex + 1]->id;
                }
                break;
            case 'Enter':
                $this->openEditModal();
                break;
        }
    }

    #[On('district-updated')]
    #[On('district-created')]
    #[On('district-deleted')]
    public function refreshData()
    {
        $this->selectedRow = null;
    }


    public function render()
    {
        return view('livewire.district.district-table', [
            'districts' => $this->getFilteredDistricts()
        ]);
    }
}
