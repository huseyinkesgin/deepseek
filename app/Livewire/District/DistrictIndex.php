<?php

namespace App\Livewire\District;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

class DistrictIndex extends Component
{
   

    protected $listeners = [
        'showModal' => 'handleShowModal',
        'showDeleteModal' => 'handleShowDeleteModal'
    ];

    #[Title('İlçeler')]
    public function render()
    {
        return view('livewire.district.district-index');
    }

   
}
