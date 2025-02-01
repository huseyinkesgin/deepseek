<?php

namespace App\Http\Livewire\District;

use Livewire\Component;
use App\Traits\WithModal;
use App\Models\District;
use App\Models\City;

class DistrictComponent extends Component
{
    use WithModal;

    public $district;
    public $selectedCity;
    public $citySearchTerm = '';
    public $searchTerm = ''; // DataTable için arama terimi
    public $row;

    protected $rules = [
        'district.name' => 'required|min:3',
        'district.city_id' => 'required|exists:cities,id',
    ];

    public function mount()
    {
        $this->district = new District();
    }

    public function render()
    {
        $cities = City::where('name', 'like', '%'.$this->citySearchTerm.'%')->get();
        $districts = District::query() // DataTable için sorgu
            ->when($this->searchTerm, function ($query) {
                $query->where('name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhereHas('city', function ($query) {
                        $query->where('name', 'like', '%' . $this->searchTerm . '%');
                    });
            })
            ->paginate(10);


        $districtColumns = [ // DataTable için sütun tanımları
            ['name' => 'id', 'label' => 'ID'],
            ['name' => 'name', 'label' => 'İlçe Adı'],
            ['name' => 'city.name', 'label' => 'İl Adı'],
        ];


        return view('livewire.district.district-component', [
            'cities' => $cities,
            'districts' => $districts,
            'districtColumns' => $districtColumns,
        ]);
    }

    public function openCitySelector()
    {
        $this->emit('showListModal');
    }

    public function selectCity($cityId)
    {
        $this->selectedCity = City::find($cityId);
        $this->district->city_id = $cityId;
        $this->emit('hideListModal');
    }

    public function save()
    {
        $this->validate();
        $this->district->save();
        $this->emit('hideFormModal');
        $this->emit('showMessageModal');
    }
}
