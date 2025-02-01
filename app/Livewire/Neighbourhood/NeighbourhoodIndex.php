<?php

namespace App\Livewire\Neighbourhood;

use Livewire\Component;
use Livewire\Attributes\Title;
class NeighbourhoodIndex extends Component
{
    protected $listeners = [
        'showModal' => 'handleShowModal',
        'showDeleteModal' => 'handleShowDeleteModal'
    ];

    #[Title('Mahalleler')]
    public function render()
    {
        return view('livewire.neighbourhood.neighbourhood-index');
    }
}
