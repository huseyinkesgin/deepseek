<?php

namespace App\Livewire\District;

use App\Models\City;
use App\Models\District;
use Livewire\Component;
use Livewire\Attributes\On;

class DistrictEdit extends Component
{
    public $code;
    public $city_id;
    public $name;
    public $description;
    public $status;
    public $districtId;
    public $showModal = false;
    public $cities;

    protected function rules()
    {
        return [
            'code' => 'required|string|unique:districts,code,' . $this->districtId,
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ];
    }

    protected $messages = [
        'code.required' => 'Kod alanı zorunludur.',
        'code.unique' => 'Bu kod daha önce kullanılmış.',
        'name.required' => 'İlçe adı alanı zorunludur.',
        'city_id.required' => 'İl alanı zorunludur.',
        'city_id.exists' => 'Geçersiz il seçildi.',
    ];

    public function mount()
    {
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
    }

    #[On('showDistrictEditModal')]
    public function show($data)
    {
        if (isset($data['id'])) {
            $district = District::find($data['id']);
            $this->districtId = $district->id;
            $this->code = $district->code;
            $this->city_id = $district->city_id;
            $this->name = $district->name;
            $this->description = $district->description;
            $this->status = $district->status;
            $this->showModal = true;
        }
    }

    public function save()
    {
        $this->validate();

        $district = District::find($this->districtId);
        $district->update([
            'code' => $this->code,
            'city_id' => $this->city_id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
        ]);

        $this->dispatch('district-updated');
        $this->resetForm();
        $this->close();
    }

    public function resetForm()
    {
        $this->reset(['name', 'city_id', 'description', 'status']);
    }

    public function close()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.district.district-edit');
    }
}
