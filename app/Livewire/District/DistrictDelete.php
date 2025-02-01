<?php

namespace App\Livewire\District;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\District;

class DistrictDelete extends Component
{
    public $showModal = false;
    public $districtId;
    public $districtName;

    #[On('showDistrictDeleteModal')]
    public function show($data)
    {
        if (isset($data['id'])) {
            $district = District::find($data['id']);
            $this->districtId = $district->id;
            $this->districtName = $district->name;
            $this->showModal = true;
        }
    }

    public function delete()
    {
        $district = District::find($this->districtId);
        $district->delete();

        $this->dispatch('district-deleted');
        $this->close();
    }

    public function close()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.district.district-delete');
    }
}
