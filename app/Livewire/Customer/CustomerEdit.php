<?php

namespace App\Livewire\Customer;

use App\Models\City;
use App\Models\Company;
use App\Models\Customer;
use App\Models\District;
use App\Models\Neighbourhood;
use Livewire\Component;
use Livewire\Attributes\On;

class CustomerEdit extends Component
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
    public $status;
    public $description;
    public $customerId;
    public $showModal = false;

    public $cities;
    public $districts = [];
    public $neighbourhoods = [];
    public $companies;

    protected function rules()
    {
        return [
            'code' => 'required|string|unique:customers,code,' . $this->customerId,
            'name' => 'required|string',
            'surname' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'required|exists:districts,id',
            'neighbourhood_id' => 'required|exists:neighbourhoods,id',
            'company_id' => 'required|exists:companies,id',
            'identity_number' => 'nullable|string',
            'tax_number' => 'nullable|string',
            'tax_office' => 'nullable|string',
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

    #[On('showCustomerEditModal')]
    public function show($data)
    {
        if (isset($data['id'])) {
            $customer = Customer::find($data['id']);
            $this->customerId = $customer->id;
            $this->code = $customer->code;
            $this->name = $customer->name;
            $this->surname = $customer->surname;
            $this->phone = $customer->phone;
            $this->email = $customer->email;
            $this->address = $customer->address;
            $this->identity_number = $customer->identity_number;
            $this->tax_number = $customer->tax_number;
            $this->tax_office = $customer->tax_office;
            $this->status = $customer->status;
            $this->description = $customer->description;
            $this->company_id = $customer->company_id;

            // Önce il'i set et
            $this->city_id = $customer->city_id;
            // İl'e bağlı ilçeleri yükle
            $this->districts = District::where('city_id', $this->city_id)
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

            // Sonra ilçeyi set et
            $this->district_id = $customer->district_id;
            // İlçeye bağlı mahalleleri yükle
            $this->neighbourhoods = Neighbourhood::where('district_id', $this->district_id)
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

            // En son mahalleyi set et
            $this->neighbourhood_id = $customer->neighbourhood_id;

            $this->showModal = true;
        }
    }

    public function save()
    {
        $this->validate();

        $customer = Customer::find($this->customerId);
        $customer->update([
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

        $this->dispatch('customer-updated');
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
        return view('livewire.customer.customer-edit');
    }
}
