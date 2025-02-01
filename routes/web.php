<?php

use App\Livewire\City\CityIndex;
use Illuminate\Support\Facades\Route;
use App\Livewire\District\DistrictIndex;
use App\Livewire\Neighbourhood\NeighbourhoodIndex;
use App\Livewire\Company\CompanyIndex;
use App\Livewire\Customer\CustomerIndex;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/districts', DistrictIndex::class)->name('districts');
Route::get('/cities', CityIndex::class)->name('cities');
Route::get('/neighbourhoods', NeighbourhoodIndex::class)->name('neighbourhoods');
Route::get('/companies', CompanyIndex::class)->name('companies');
Route::get('/customers', CustomerIndex::class)->name('customers');
Route::get('/customers', CustomerIndex::class)->name('customers');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
