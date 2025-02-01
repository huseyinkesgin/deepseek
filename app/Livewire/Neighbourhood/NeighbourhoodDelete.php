<?php

namespace App\Livewire\Neighbourhood;

use Livewire\Component;
use App\Models\Neighbourhood;
use Livewire\Attributes\On;

class NeighbourhoodDelete extends Component
{
    public $showModal = false;
    public $neighbourhoodId;
    public $neighbourhoodName;

    #[On('showNeighbourhoodDeleteModal')]
    public function show($data)
    {
        if (isset($data['id'])) {
            $neighbourhood = Neighbourhood::find($data['id']);
            $this->neighbourhoodId = $neighbourhood->id;
            $this->neighbourhoodName = $neighbourhood->name;
            $this->showModal = true;
        }
    }

    public function delete()
    {
        $neighbourhood = Neighbourhood::find($this->neighbourhoodId);
        $neighbourhood->delete();

        $this->dispatch('neighbourhood-deleted');
        $this->close();
    }

    public function close()
    {
        $this->showModal = false;
    }
    public function render()
    {
        return view('livewire.neighbourhood.neighbourhood-delete');
    }
}
