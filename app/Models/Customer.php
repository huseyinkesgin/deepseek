<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use App\Models\Company;
use App\Models\City;
use App\Models\District;
use App\Models\Neighbourhood;


class Customer extends Model
{
    protected $fillable = [
        'code',
        'name',
        'surname',
        'phone',
        'email',
        'address',
        'city_id',
        'district_id',
        'neighbourhood_id',
        'company_id',
        'identity_number',
        'tax_number',
        'tax_office',
        'status',
        'description'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
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

    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->surname;
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
              ->orWhere('surname', 'like', "%{$term}%")
              ->orWhere('code', 'like', "%{$term}%")
              ->orWhere('phone', 'like', "%{$term}%")
              ->orWhere('email', 'like', "%{$term}%")
              ->orWhere('identity_number', 'like', "%{$term}%")
              ->orWhere('tax_number', 'like', "%{$term}%")
              ->orWhere('tax_office', 'like', "%{$term}%")
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

    // Mutator'lar
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
