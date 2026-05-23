<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ward;

class WardSeeder extends Seeder
{
    public function run(): void
    {
        $wards = [
            ['name' => 'Ward 1', 'total_beds' => 24, 'occupied_beds' => 0],
            ['name' => 'Ward 2', 'total_beds' => 24, 'occupied_beds' => 0],
            ['name' => 'Ward 3', 'total_beds' => 24, 'occupied_beds' => 0],
            ['name' => 'Ward 4', 'total_beds' => 24, 'occupied_beds' => 0],
            ['name' => 'Ward 5', 'total_beds' => 24, 'occupied_beds' => 0],
        ];

        foreach ($wards as $ward) {
            Ward::create($ward);
        }
    }
}
