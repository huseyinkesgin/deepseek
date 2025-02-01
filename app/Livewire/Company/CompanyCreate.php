<?php

namespace App\Livewire\Company;

use App\Models\City;
use App\Models\Company;
use App\Models\District;
use App\Models\Neighbourhood;
use Livewire\Component;
use Livewire\Attributes\On;

class CompanyCreate extends Component
{
    public $code;
    public $name;
    public $tax_name;
    public $tax_number;
    public $tax_office;
    public $phone;
    public $email;
    public $address;
    public $city_id;
    public $district_id;
    public $neighbourhood_id;
    public $mersis_no;
    public $kep_address;
    public $iban;
    public $bank_name;
    public $bank_account_no;
    public $status = 1;
    public $description;
    public $showModal = false;

    public $cities;
    public $districts = [];
    public $neighbourhoods = [];

    protected function rules()
    {
        return [
            'code' => 'required|string|max:25|unique:companies,code',
            'name' => 'required|string|max:100',
            'tax_name' => 'nullable|string|max:150',
            'tax_number' => 'nullable|string|max:10',
            'tax_office' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:16',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable|string|max:200',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'required|exists:districts,id',
            'neighbourhood_id' => 'required|exists:neighbourhoods,id',
            'mersis_no' => 'nullable|string|max:30',
            'kep_address' => 'nullable|string|max:45',
            'iban' => 'nullable|string|max:36',
            'bank_name' => 'nullable|string|max:100',
            'bank_account_no' => 'nullable|string|max:36',
            'status' => 'required|boolean',
            'description' => 'nullable|string|max:255',
        ];
    }

    protected $messages = [
        'code.required' => 'Kod alanı zorunludur.',
        'code.max' => 'Kod alanı en fazla 25 karakter olmalıdır.',
        'code.unique' => 'Bu kod daha önce kullanılmış.',
        'name.required' => 'Firma adı zorunludur.',
        'name.max' => 'Firma adı en fazla 100 karakter olmalıdır.',
        'email.email' => 'Geçerli bir e-posta adresi giriniz.',
        'email.max' => 'E-posta adresi en fazla 100 karakter olmalıdır.',
        'phone.max' => 'Telefon numarası en fazla 16 karakter olmalıdır.',
        'address.max' => 'Adres en fazla 200 karakter olmalıdır.',
        'city_id.exists' => 'Geçersiz il seçildi.',
        'city_id.required' => 'İl seçimi zorunlu alandır.',
        'district_id.exists' => 'Geçersiz ilçe seçildi.',
        'district_id.required' => 'İlçe seçimi zorunlu alandır.',
        'neighbourhood_id.exists' => 'Geçersiz mahalle seçildi.',
        'neighbourhood_id.required' => 'Mahalle seçimi zorunlu alandır.',
        'status.required' => 'Durum seçimi zorunlu alandır.',
        'status.boolean' => 'Geçersiz durum seçildi.',
        'description.max' => 'Açıklama en fazla 255 karakter olmalıdır.',
        'tax_name.max' => 'Vergi adı en fazla 150 karakter olmalıdır.',
        'tax_number.max' => 'Vergi numarası en fazla 10 karakter olmalıdır.',
        'tax_office.max' => 'Vergi ofisi en fazla 100 karakter olmalıdır.',
        'mersis_no.max' => 'Mersis numarası en fazla 30 karakter olmalıdır.',
        'kep_address.max' => 'Kep adresi en fazla 45 karakter olmalıdır.',
        'iban.max' => 'IBAN numarası en fazla 36 karakter olmalıdır.',
        'bank_name.max' => 'Banka adı en fazla 100 karakter olmalıdır.',
        'bank_account_no.max' => 'Banka hesap numarası en fazla 36 karakter olmalıdır.',
    ];

    #[On('city-created')]
    public function mount()
    {
        $this->loadCities();
    }

    public function loadCities()
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

    #[On('district-created')]
    public function refreshDistricts()
    {
        if($this->city_id) {
            $this->updatedCityId($this->city_id);
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

    #[On('neighbourhood-created')]
    public function refreshNeighbourhoods()
    {
        if($this->district_id) {
            $this->updatedDistrictId($this->district_id);
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
        $codes = Company::pluck('code')
            ->map(function($code) {
                return (int) substr($code, 7); // "FIRMA-" 7 karakter
            })
            ->sort()
            ->values()
            ->toArray();

        $nextNumber = 1;

        foreach($codes as $index => $number) {
            if($number != $index + 1) {
                $nextNumber = $index + 1;
                break;
            }
            $nextNumber = $number + 1;
        }

        $this->code = 'FIRMA-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    public function save()
    {
        $this->validate();

        Company::create([
            'code' => $this->code,
            'name' => $this->name,
            'tax_name' => $this->tax_name,
            'tax_number' => $this->tax_number,
            'tax_office' => $this->tax_office,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'city_id' => $this->city_id,
            'district_id' => $this->district_id,
            'neighbourhood_id' => $this->neighbourhood_id,
            'mersis_no' => $this->mersis_no,
            'kep_address' => $this->kep_address,
            'iban' => $this->iban,
            'bank_name' => $this->bank_name,
            'bank_account_no' => $this->bank_account_no,
            'status' => $this->status,
            'description' => $this->description,
        ]);

        $this->dispatch('company-created');
        $this->resetForm();
        $this->close();
    }

    public function resetForm()
    {
        $this->reset([
            'name', 'tax_name', 'tax_number', 'tax_office', 'phone', 'email',
            'address', 'city_id', 'district_id', 'neighbourhood_id', 'mersis_no',
            'kep_address', 'iban', 'bank_name', 'bank_account_no', 'status', 'description'
        ]);
        $this->districts = [];
        $this->neighbourhoods = [];
    }

    public function close()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.company.company-create');
    }
}
