<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Customer;

class CustomerFollow extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'customer_id', 'service_type', 'portfolio_id', 'personnel_id', 'description'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
