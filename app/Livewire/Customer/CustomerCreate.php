<?php

namespace App\Livewire\Customer;

use App\Models\City;
use App\Models\Company;
use App\Models\Customer;
use App\Models\District;
use App\Models\Neighbourhood;
use Livewire\Component;
use Livewire\Attributes\On;

class CustomerCreate extends Component
{
    public $code;
    public $name;
    public $surname;
    public $phone;
    public $email;
    public $address;
    public $city_id;
    public $district_id;
    public $neighbourhood_id;
    public $company_id;
    public $identity_number;
    public $tax_number;
    public $tax_office;
    public $status = 1;
    public $description;
    public $showModal = false;

    public $cities;
    public $districts = [];
    public $neighbourhoods = [];
    public $companies;

    protected function rules()
    {
        return [
            'code' => 'required|string|max:25|unique:customers,code',
            'name' => 'required|string|max:100',
            'surname' => 'required|string|max:100',
            'phone' => 'nullable|string|max:16',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable|string|max:200',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'required|exists:districts,id',
            'neighbourhood_id' => 'required|exists:neighbourhoods,id',
            'company_id' => 'required|exists:companies,id',
            'identity_number' => 'nullable|string|max:11',
            'tax_number' => 'nullable|string|max:10',
            'tax_office' => 'nullable|string|max:100',
            'status' => 'required|boolean',
            'description' => 'nullable|string',
        ];
    }

    protected $messages = [
        'code.required' => 'Kod alanı zorunludur.',
        'code.unique' => 'Bu kod daha önce kullanılmış.',
        'name.required' => 'Ad alanı zorunludur.',
        'surname.required' => 'Soyad alanı zorunludur.',
        'email.email' => 'Geçerli bir e-posta adresi giriniz.',
        'city_id.required' => 'İl seçimi zorunludur.',
        'district_id.required' => 'İlçe seçimi zorunludur.',
        'neighbourhood_id.required' => 'Mahalle seçimi zorunludur.',
        'company_id.required' => 'Firma seçimi zorunludur.',
    ];

    #[On('city-created')]
    #[On('company-created')]
    public function mount()
    {
        $this->loadCities();
        $this->loadCompanies();
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

    public function loadCompanies()
    {
        $this->companies = Company::where('status', true)
            ->orderBy('name')
            ->get()
            ->map(function($company) {
                return [
                    'value' => $company->id,
                    'label' => $company->name
                ];
            })
            ->toArray();
    }

    public function updatedCityId($value)
    {
        $this->district_id = null;
        $this->neighbourhood_id = null;
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
        $this->neighbourhood_id = null;
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
        $codes = Customer::pluck('code')
            ->map(function($code) {
                return (int) substr($code, 9); // "MUSTERI-" 9 karakter
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

        $this->code = 'MUSTERI-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    public function save()
    {
        $this->validate();

        Customer::create([
            'code' => $this->code,
            'name' => $this->name,
            'surname' => $this->surname,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'city_id' => $this->city_id,
            'district_id' => $this->district_id,
            'neighbourhood_id' => $this->neighbourhood_id,
            'company_id' => $this->company_id,
            'identity_number' => $this->identity_number,
            'tax_number' => $this->tax_number,
            'tax_office' => $this->tax_office,
            'status' => $this->status,
            'description' => $this->description,
        ]);

        $this->dispatch('customer-created');
        $this->resetForm();
        $this->close();
    }

    public function resetForm()
    {
        $this->reset([
            'name', 'surname', 'phone', 'email', 'address', 'city_id',
            'district_id', 'neighbourhood_id', 'company_id', 'identity_number',
            'tax_number', 'tax_office', 'status', 'description'
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
        return view('livewire.customer.customer-create');
    }
}
