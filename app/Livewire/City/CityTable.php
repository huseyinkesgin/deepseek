<?php

namespace App\Livewire\City;

use App\Models\City;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class CityTable extends Component
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
        $firstCity = $this->getFilteredCities()->first();
        if($firstCity) {
            $this->selectedRow = $firstCity->id;
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

    protected function getFilteredCities()
    {
        return City::search($this->search)
            ->active($this->activeFilter !== '' ? $this->activeFilter : null)
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function openEditModal($id = null)
    {
        $id = $id ?? $this->selectedRow;
        if($id) {
            $this->dispatch('showCityEditModal', ['id' => $id]);
        }
    }

    public function openDeleteModal($id = null)
    {
        $id = $id ?? $this->selectedRow;
        if($id) {
            $this->dispatch('showCityDeleteModal', ['id' => $id]);
        }
    }

    public function handleKeyDown($data)
    {
        if(!$this->selectedRow) return;

        $cities = $this->getFilteredCities()->items();
        $currentIndex = collect($cities)->search(function($city) {
            return $city->id === $this->selectedRow;
        });

        switch($data['key']) {
            case 'ArrowUp':
                if($currentIndex > 0) {
                    $this->selectedRow = $cities[$currentIndex - 1]->id;
                }
                break;
            case 'ArrowDown':
                if($currentIndex < count($cities) - 1) {
                    $this->selectedRow = $cities[$currentIndex + 1]->id;
                }
                break;
            case 'Enter':
                $this->openEditModal();
                break;
        }
    }

    #[On('city-updated')]
    #[On('city-created')]
    #[On('city-deleted')]
    public function refreshData()
    {
        $this->selectedRow = null;
    }

    public function render()
    {
        return view('livewire.city.city-table', [
            'cities' => $this->getFilteredCities()
        ]);
    }
}
