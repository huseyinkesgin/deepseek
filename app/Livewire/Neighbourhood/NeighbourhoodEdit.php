<?php

namespace App\Livewire\Neighbourhood;

use Livewire\Component;
use App\Models\District;
use App\Models\Neighbourhood;
use App\Models\City;
use Livewire\Attributes\On;


class NeighbourhoodEdit extends Component
{

    public $code;
    public $districtId;
    public $name;
    public $description;
    public $status;
    public $showModal = false;

    public $districts;
    public $cities;

    protected function rules()
    {
        return [
            'code' => 'required|string',
            'name' => 'required|string',
            'districtId' => 'required|exists:districts,id',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ];
    }

    protected $messages = [
        'code.required' => 'Kod alanı zorunludur.',
        'name.required' => 'İlçe adı alanı zorunludur.',
        'status.required' => 'Aktif alanı zorunludur.',
        'districtId.required' => 'İlçe alanı zorunludur.',
        'districtId.exists' => 'İlçe bulunamadı.',
    ];

    #[On('showNeighbourhoodEditModal')]
    public function show($data)
    {
        if (isset($data['id'])) {
            $this->loadNeighbourhood($data['id']);
            $this->showModal = true;
            $this->dispatch('modal-opened');
        }
    }

    public function loadNeighbourhood($id)
    {
        $neighbourhood = Neighbourhood::findOrFail($id);
        
        $this->districtId = $neighbourhood->district_id;
        $this->code = $neighbourhood->code;
        $this->name = $neighbourhood->name;
        $this->description = $neighbourhood->description;
        $this->status = $neighbourhood->status;
    }

    public function save()
    {
        $this->validate();

        $neighbourhood = Neighbourhood::findOrFail($this->neighbourhoodId);
        $neighbourhood->update([
            'code' => $this->code,
            'name' => $this->name,
            'district_id' => $this->districtId,
            'description' => $this->description,
            'status' => $this->status,
        ]);

        $this->dispatch('district-updated');
        $this->resetForm();
        $this->close();
    }

    public function resetForm()
    {
        $this->reset([ 'name', 'description', 'status', 'districtId']);
    }

    public function close()
    {
        $this->showModal = false;
    }


    public function render()
    {
        $this->districts = District::where('status', true)
            ->orderBy('name')
            ->get()
            ->map(function($district) {
                return [
                    'value' => $district->id,
                    'label' => $district->name
                ];
            })
            ->toArray();
        $this->cities = City::where('status', true)
            ->orderBy('name')
            ->get()
            ->map(function($city) {
                return [
                    'value' => $city->id,
                    'label' => $city->name
                ];
            })
            ->toArray();
        return view('livewire.neighbourhood.neighbourhood-edit', [
            'districts' => $this->districts,
            'cities' => $this->cities,
        ]);
    }
}
