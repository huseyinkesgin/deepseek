<?php

namespace App\Livewire\City;

use App\Models\City;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Livewire\City\CityTable;
use App\Livewire\District\DistrictCreate;

class CityCreate extends Component
{
    public $code;
    public $name;
    public $description;
    public $status = 1;
    public $showModal = false;

    protected function rules()
    {
        return [
            'code' => 'required|string|unique:cities,code',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ];
    }

    protected $messages = [
        'code.required' => 'Kod alanı zorunludur.',
        'code.unique' => 'Bu kod daha önce kullanılmış.',
        'name.required' => 'İl adı alanı zorunludur.',
    ];

    public function openModal()
    {
        $this->resetForm();
        $this->generateNextCode();
        $this->showModal = true;
        $this->dispatch('modal-opened');
    }

    protected function generateNextCode()
    {
        // Tüm kodları al ve numaralarını çıkar
        $codes = City::pluck('code')
            ->map(function($code) {
                return (int) substr($code, 3); // "IL-01" -> 1
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
        $this->code = 'IL-' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
    }

    public function save()
    {
        $this->validate();

        City::create([
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
        ]);

        $this->dispatch('city-created');
        $this->resetForm();
        $this->close();
    }

    public function resetForm()
    {
        $this->reset(['name', 'description', 'status']);
        // code'u resetleme çünkü otomatik oluşturulacak
    }

    public function close()
    {
        $this->showModal = false;
    }



    public function render()
    {
        return view('livewire.city.city-create');
    }
}