<?php

namespace App\Livewire\City;

use Livewire\Component;

#[Title('İller')]
class CityIndex extends Component
{
    public function render()
    {
        return view('livewire.city.city-index');
    }
}
