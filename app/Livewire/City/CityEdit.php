<?php

namespace App\Livewire\City;

use App\Models\City;
use Livewire\Component;
use Livewire\Attributes\On;

class CityEdit extends Component
{
    public $code;
    public $name;
    public $description;
    public $status;
    public $cityId;
    public $showModal = false;

    protected function rules()
    {
        return [
            'code' => 'required|string',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ];
    }

    protected $messages = [
        'code.required' => 'Kod alanı zorunludur.',
        'name.required' => 'İl adı alanı zorunludur.',
        'status.required' => 'Aktif alanı zorunludur.',
    ];

    #[On('showCityEditModal')]
    public function show($data)
    {
        if (isset($data['id'])) {
            $this->loadCity($data['id']);
            $this->showModal = true;
            $this->dispatch('modal-opened');
        }
    }

    public function loadCity($id)
    {
        $city = City::findOrFail($id);
        $this->cityId = $city->id;
        $this->code = $city->code;
        $this->name = $city->name;
        $this->description = $city->description;
        $this->status = $city->status;
    }

    public function save()
    {
        $this->validate();

        $city = City::findOrFail($this->cityId);
        $city->update([
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
        ]);

        $this->dispatch('city-updated');
        $this->resetForm();
        $this->close();
    }

    public function resetForm()
    {
        $this->reset([ 'name', 'description', 'status']);
    }

    public function close()
    {
        $this->showModal = false;
    }



    public function render()
    {
        return view('livewire.city.city-edit');
    }
}
