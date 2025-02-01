<?php

namespace App\Livewire\City;

use App\Models\City;
use Livewire\Component;
use Livewire\Attributes\On;

class CityDelete extends Component
{
    public $showModal = false;
    public $cityId;
    public $cityName;

    #[On('showCityDeleteModal')]
    public function show($data)
    {
        if (isset($data['id'])) {
            $city = City::find($data['id']);
            $this->cityId = $city->id;
            $this->cityName = $city->name;
            $this->showModal = true;
        }
    }

    public function delete()
    {
        $city = City::find($this->cityId);
        $city->delete();

        $this->dispatch('city-deleted');
        $this->close();
    }

    public function close()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.city.city-delete');
    }
}
