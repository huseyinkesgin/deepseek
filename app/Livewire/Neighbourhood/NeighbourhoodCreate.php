<?php

namespace App\Livewire\Neighbourhood;

use App\Models\City;
use Livewire\Component;
use App\Models\District;
use Livewire\Attributes\On;
use App\Models\Neighbourhood;

class NeighbourhoodCreate extends Component
{
    public $code;
    public $city_id;
    public $district_id;
    public $name;
    public $description;
    public $status = 1;
    public $showModal = false;

    public $cities;
    public $districts = [];
    public $neighbourhoods = [];

    protected function rules()
    {
        return [
            'code' => 'required|string|unique:neighbourhoods,code',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'required|exists:districts,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ];
    }

    protected $messages = [
        'code.required' => 'Kod alanı zorunludur.',
        'code.unique' => 'Bu kod daha önce kullanılmış.',
        'name.required' => 'Mahalle adı alanı zorunludur.',
        'city_id.required' => 'İl alanı zorunludur.',
        'city_id.exists' => 'Geçersiz il seçildi.',
        'district_id.required' => 'İlçe alanı zorunludur.',
        'district_id.exists' => 'Geçersiz ilçe seçildi.',
    ];

    #[On('city-created')]
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


    public function updatedCityId($value)
    {
        $this->district_id = null; // İl değiştiğinde ilçe seçimini sıfırla
        $this->neighbourhood_id = null; // İl değiştiğinde mahalle seçimini sıfırla
        $this->districts = [];
        $this->neighbourhoods = [];

        if($value) {
            $this->districts = District::where('city_id', $value)
                ->where('status', true)
                ->orderBy('name')
                ->get()
                ->map(function($district) {
                    return [
                        'value' => $district->id,
                        'label' => $district->name
                    ];
                })
                ->toArray();
        }
    }

    public function updatedDistrictId($value)
    {
        $this->neighbourhood_id = null; // İlçe değiştiğinde mahalle seçimini sıfırla
        $this->neighbourhoods = [];

        if($value) {
            $this->neighbourhoods = Neighbourhood::where('district_id', $value)
                ->where('status', true)
                ->orderBy('name')
                ->get()
                ->map(function($neighbourhood) {
                    return [
                        'value' => $neighbourhood->id,
                        'label' => $neighbourhood->name
                    ];
                })
                ->toArray();
        }
    }

    public function openModal()
    {
        $this->resetForm();
        $this->generateNextCode();
        $this->showModal = true;
    }

    protected function generateNextCode()
    {
        $codes = Neighbourhood::pluck('code')
            ->map(function($code) {
                return (int) substr($code, 8); // "MAHALLE-" 8 karakter
            })
            ->sort()
            ->values()
            ->toArray();

        $nextNumber = 1;

        // Boşluk olan ilk sayıyı bul
        foreach($codes as $index => $number) {
            if($number != $index + 1) {
                $nextNumber = $index + 1;
                break;
            }
            $nextNumber = $number + 1;
        }

        // 3 haneli kod oluştur
        $this->code = 'MAHALLE-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    public function save()
    {
        $this->validate();

        Neighbourhood::create([
            'code' => $this->code,
            'city_id' => $this->city_id,
            'district_id' => $this->district_id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
        ]);

        $this->dispatch('neighbourhood-created');
        $this->resetForm();
        $this->close();
    }

    public function resetForm()
    {
        $this->reset(['name', 'city_id', 'district_id', 'description', 'status']);
        $this->districts = [];
        $this->neighbourhoods = [];
    }

    public function close()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.neighbourhood.neighbourhood-create');
    }
}
