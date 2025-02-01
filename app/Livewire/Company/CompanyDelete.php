<?php

namespace App\Livewire\Company;

use App\Models\Company;
use Livewire\Component;
use Livewire\Attributes\On;

class CompanyDelete extends Component
{
    public $showModal = false;
    public $companyId;
    public $name;
    public $code;

    #[On('showCompanyDeleteModal')]
    public function show($data)
    {
        if (isset($data['id'])) {
            $company = Company::find($data['id']);
            $this->companyId = $company->id;
            $this->name = $company->name;
            $this->code = $company->code;
            $this->showModal = true;
        }
    }

    public function delete()
    {
        $company = Company::find($this->companyId);
        $company->delete();

        $this->dispatch('company-deleted');
        $this->close();
    }

    public function close()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.company.company-delete');
    }
} 