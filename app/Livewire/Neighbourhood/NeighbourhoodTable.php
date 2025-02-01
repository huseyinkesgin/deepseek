<?php

namespace App\Livewire\Neighbourhood;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\Neighbourhood;

class NeighbourhoodTable extends Component
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
        $firstNeighbourhood = $this->getFilteredNeighbourhoods()->first();
        if($firstNeighbourhood) {
            $this->selectedRow = $firstNeighbourhood->id;
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

    protected function getFilteredNeighbourhoods()
    {
        return Neighbourhood::search($this->search)
            ->active($this->activeFilter !== '' ? $this->activeFilter : null)
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function openEditModal($id = null)
    {
        $id = $id ?? $this->selectedRow;
        if($id) {
            $this->dispatch('showNeighbourhoodEditModal', ['id' => $id]);
        }
    }

    public function openDeleteModal($id = null)
    {
        $id = $id ?? $this->selectedRow;
        if($id) {
            $this->dispatch('showNeighbourhoodDeleteModal', ['id' => $id]);
        }
    }

    public function handleKeyDown($data)
    {
        if(!$this->selectedRow) return;

        $neighbourhoods = $this->getFilteredNeighbourhoods()->items();
        $currentIndex = collect($neighbourhoods)->search(function($neighbourhood) {
            return $neighbourhood->id === $this->selectedRow;
        });

        switch($data['key']) {
            case 'ArrowUp':
                if($currentIndex > 0) {
                    $this->selectedRow = $neighbourhoods[$currentIndex - 1]->id;
                }
                break;
            case 'ArrowDown':
                if($currentIndex < count($neighbourhoods) - 1) {
                    $this->selectedRow = $neighbourhoods[$currentIndex + 1]->id;
                }
                break;
            case 'Enter':
                $this->openEditModal();
                break;
        }
    }

    #[On('neighbourhood-updated')]
    #[On('neighbourhood-created')]
    #[On('neighbourhood-deleted')]
    public function refreshData()
    {
        $this->selectedRow = null;
    }

    public function render()
    {
        return view('livewire.neighbourhood.neighbourhood-table', [
            'neighbourhoods' => $this->getFilteredNeighbourhoods(),
        ]);
    }
}
