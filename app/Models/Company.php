<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use App\Models\Customer;
use App\Models\City;
use App\Models\District;
use App\Models\Neighbourhood;

class Company extends Model
{
    protected $fillable = [
        'code',
        'name',
        'tax_name',
        'tax_number',
        'tax_office',
        'phone',
        'email',
        'address',
        'city_id',
        'district_id',
        'neighbourhood_id',
        'mersis_no',
        'kep_address',
        'iban',
        'bank_name',
        'bank_account_no',
        'status',
        'description'
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function neighbourhood()
    {
        return $this->belongsTo(Neighbourhood::class);
    }

    public function scopeActive(Builder $query, $status = null)
    {
        if ($status !== null) {
            return $query->where('status', $status);
        }
        return $query;
    }

    public function scopeSearch(Builder $query, $term)
    {
        return $query->where(function($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('code', 'like', "%{$term}%")
              ->orWhere('tax_name', 'like', "%{$term}%")
              ->orWhere('tax_number', 'like', "%{$term}%")
              ->orWhere('tax_office', 'like', "%{$term}%")
              ->orWhere('phone', 'like', "%{$term}%")
              ->orWhere('email', 'like', "%{$term}%")
              ->orWhere('address', 'like', "%{$term}%")
              ->orWhere('mersis_no', 'like', "%{$term}%")
              ->orWhere('kep_address', 'like', "%{$term}%")
              ->orWhere('iban', 'like', "%{$term}%")
              ->orWhere('bank_name', 'like', "%{$term}%")
              ->orWhere('bank_account_no', 'like', "%{$term}%")
              ->orWhere('description', 'like', "%{$term}%");
        });
    }

    public function attributeCreatedAt($value)
    {
        return Carbon::parse($value)->format('d.m.Y');
    }

    public function attributeUpdatedAt($value)
    {
        return Carbon::parse($value)->format('d.m.Y');
    }

    // Mutator'lar - Veriyi kaydetmeden önce dönüştürür
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = mb_strtoupper($value, 'UTF-8');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = mb_strtoupper($value, 'UTF-8');
    }

    public function setSurnameAttribute($value)
    {
        $this->attributes['surname'] = mb_strtoupper($value, 'UTF-8');
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = mb_strtoupper($value, 'UTF-8');
    }

    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = mb_strtoupper($value, 'UTF-8');
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = mb_strtoupper($value, 'UTF-8');
    }
}
