<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use App\Models\City;
use App\Models\Neighbourhood;
use Carbon\Carbon;

class District extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'city_id', 'status', 'code', 'description'];

   
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function neighbourhoods()
    {
        return $this->hasMany(Neighbourhood::class);
    }


    public function scopeSearch(Builder $query, $term)
    {
        return $query->where(function($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('code', 'like', "%{$term}%")
              ->orWhere('description', 'like', "%{$term}%");
              
        });
    }

    public function scopeActive(Builder $query, $status = null)
    {
        if ($status !== null) {
            return $query->where('status', $status);
        }
        return $query;
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

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = mb_strtoupper($value, 'UTF-8');
    }
} 