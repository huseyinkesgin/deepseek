<?php

namespace App\Livewire\Company;

use App\Models\City;
use App\Models\Company;
use App\Models\District;
use App\Models\Neighbourhood;
use Livewire\Component;
use Livewire\Attributes\On;

class CompanyEdit extends Component
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
    public $status;
    public $description;
    public $companyId;
    public $showModal = false;

    public $cities;
    public $districts = [];
    public $neighbourhoods = [];

    protected function rules()
    {
        return [
            'code' => 'required|string|unique:companies,code,' . $this->companyId,
            'name' => 'required|string',
            'tax_name' => 'nullable|string',
            'tax_number' => 'nullable|string',
            'tax_office' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'required|exists:districts,id',
            'neighbourhood_id' => 'required|exists:neighbourhoods,id',
            'mersis_no' => 'nullable|string',
            'kep_address' => 'nullable|string',
            'iban' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'bank_account_no' => 'nullable|string',
            'status' => 'required|boolean',
            'description' => 'nullable|string',
        ];
    }

    protected $messages = [
        'code.required' => 'Kod alanı zorunludur.',
        'code.unique' => 'Bu kod daha önce kullanılmış.',
        'name.required' => 'Firma adı zorunludur.',
        'email.email' => 'Geçerli bir e-posta adresi giriniz.',
        'city_id.exists' => 'Geçersiz il seçildi.',
        'city_id.required' => 'İl seçimi zorunludur.',
        'district_id.exists' => 'Geçersiz ilçe seçildi.',
        'district_id.required' => 'İlçe seçimi zorunludur.',
        'neighbourhood_id.exists' => 'Geçersiz mahalle seçildi.',
        'neighbourhood_id.required' => 'Mahalle seçimi zorunludur.',
        'status.required' => 'Durum seçimi zorunludur.',


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

    #[On('showCompanyEditModal')]
    public function show($data)
    {
        if (isset($data['id'])) {
            $company = Company::find($data['id']);
            $this->companyId = $company->id;
            $this->code = $company->code;
            $this->name = $company->name;
            $this->tax_name = $company->tax_name;
            $this->tax_number = $company->tax_number;
            $this->tax_office = $company->tax_office;
            $this->phone = $company->phone;
            $this->email = $company->email;
            $this->address = $company->address;
            $this->mersis_no = $company->mersis_no;
            $this->kep_address = $company->kep_address;
            $this->iban = $company->iban;
            $this->bank_name = $company->bank_name;
            $this->bank_account_no = $company->bank_account_no;
            $this->status = $company->status;
            $this->description = $company->description;

            // Önce il'i set et
            $this->city_id = $company->city_id;
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
            $this->district_id = $company->district_id;
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
            $this->neighbourhood_id = $company->neighbourhood_id;

            $this->showModal = true;
        }
    }

    public function save()
    {
        $this->validate();

        $company = Company::find($this->companyId);
        $company->update([
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

        $this->dispatch('company-updated');
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
        return view('livewire.company.company-edit');
    }
}
