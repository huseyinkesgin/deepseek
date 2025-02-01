<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run()
    {
        $cities = [
            [
                'id' => 1,
                'code' => 'IL-01',
                'name' => 'KOCAELİ',
                'status' => 1,
                'description' => '',
                'created_at' => '2025-01-29 04:32:15',
                'updated_at' => '2025-01-30 06:11:37'
            ],
            [
                'id' => 2,
                'code' => 'IL-02',
                'name' => 'İSTANBUL',
                'status' => 1,
                'description' => 'SSS',
                'created_at' => '2025-01-29 04:33:05',
                'updated_at' => '2025-01-30 06:11:50'
            ],
            [
                'id' => 3,
                'code' => 'IL-04',
                'name' => 'BURSA',
                'status' => 0,
                'description' => 'ASDAD',
                'created_at' => '2025-01-29 04:37:38',
                'updated_at' => '2025-01-29 11:09:14'
            ],
            [
                'id' => 4,
                'code' => 'IL-05',
                'name' => 'KOCAELİ',
                'status' => 0,
                'description' => '',
                'created_at' => '2025-01-29 07:55:49',
                'updated_at' => '2025-01-29 11:09:19'
            ],
            [
                'id' => 5,
                'code' => 'IL-06',
                'name' => 'TEKİRDAĞ',
                'status' => 0,
                'description' => '',
                'created_at' => '2025-01-29 08:02:04',
                'updated_at' => '2025-01-30 06:12:03'
            ]
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
} 