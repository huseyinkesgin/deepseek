<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    public function run()
    {
        $districts = [
            [
                'id' => 2,
                'name' => 'GEBZE',
                'code' => 'ILCE-01',
                'status' => 1,
                'description' => '',
                'city_id' => 1,
                'created_at' => '2025-01-30 06:15:23',
                'updated_at' => '2025-01-30 06:15:23'
            ],
            [
                'id' => 4,
                'name' => 'DARICA',
                'code' => 'ILCE-02',
                'status' => 1,
                'description' => '',
                'city_id' => 1,
                'created_at' => '2025-01-30 06:20:39',
                'updated_at' => '2025-01-30 06:20:39'
            ],
            [
                'id' => 5,
                'name' => 'ÇAYIROVA',
                'code' => 'ILCE-03',
                'status' => 1,
                'description' => '',
                'city_id' => 1,
                'created_at' => '2025-01-30 08:01:11',
                'updated_at' => '2025-01-30 08:01:11'
            ],
            [
                'id' => 6,
                'name' => 'TUZLA',
                'code' => 'ILCE-04',
                'status' => 1,
                'description' => '',
                'city_id' => 2,
                'created_at' => '2025-01-30 08:01:31',
                'updated_at' => '2025-01-30 08:01:31'
            ],
            [
                'id' => 7,
                'name' => 'ATAŞEHİR',
                'code' => 'ILCE-05',
                'status' => 1,
                'description' => '',
                'city_id' => 2,
                'created_at' => '2025-01-30 08:01:43',
                'updated_at' => '2025-01-30 08:01:43'
            ],
            [
                'id' => 8,
                'name' => 'KARTAL',
                'code' => 'ILCE-06',
                'status' => 1,
                'description' => '',
                'city_id' => 2,
                'created_at' => '2025-01-30 08:01:52',
                'updated_at' => '2025-01-30 08:01:52'
            ],
            [
                'id' => 9,
                'name' => 'DILOVASI',
                'code' => 'ILCE-07',
                'status' => 1,
                'description' => '',
                'city_id' => 1,
                'created_at' => '2025-01-30 09:19:44',
                'updated_at' => '2025-01-30 09:19:44'
            ]
        ];

        foreach ($districts as $district) {
            District::create($district);
        }
    }
} 