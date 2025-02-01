<?php

namespace App\Livewire\District;

use App\Models\City;
use Livewire\Component;
use App\Models\District;
use Livewire\Attributes\On;

class DistrictCreate extends Component
{
    public $code;
    public $city_id;
    public $name;
    public $description;
    public $status = 1;
    public $showModal = false;
    public $cities;

    protected function rules()
    {
        return [
            'code' => 'required|string|unique:districts,code',
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

    public function openModal()
    {
        $this->resetForm();
        $this->generateNextCode();
        $this->showModal = true;
        $this->dispatch('modal-opened');
    }

    protected function generateNextCode()
    {
        // İlçe kodlarını al ve numaralarını çıkar
        $codes = District::pluck('code')
            ->map(function($code) {
                return (int) substr($code, 5);
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

        // Yeni kodu oluştur
        $this->code = 'ILCE-' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
    }

    public function save()
    {
        $this->validate();

        District::create([
            'code' => $this->code,
            'name' => $this->name,
            'city_id' => $this->city_id,
            'description' => $this->description,
            'status' => $this->status,
        ]);

        $this->dispatch('district-created');
        $this->resetForm();
        $this->close();
    }

    public function resetForm()
    {
        $this->reset(['name', 'description', 'status', 'city_id']);
        // code'u resetleme çünkü otomatik oluşturulacak
    }

    public function close()
    {
        $this->showModal = false;
    }




    public function render()
    {
        return view('livewire.district.district-create');
    }
}
