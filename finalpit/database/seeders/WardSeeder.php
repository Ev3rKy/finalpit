<?php

namespace Database\Seeders;

use App\Models\Ward;
use Illuminate\Database\Seeder;

class WardSeeder extends Seeder
{
    public function run(): void
    {
        $wards = [
            ['ward_number' => 11, 'ward_name' => 'Orthopaedic', 'location' => 'Block E', 'total_beds' => 28, 'tel_extn' => '7711'],
            ['ward_number' => 12, 'ward_name' => 'General Surgery', 'location' => 'Block C', 'total_beds' => 32, 'tel_extn' => '7712'],
            ['ward_number' => 13, 'ward_name' => 'Maternity', 'location' => 'Block A', 'total_beds' => 24, 'tel_extn' => '7713'],
        ];

        foreach ($wards as $ward) {
            Ward::updateOrCreate(
                ['ward_number' => $ward['ward_number']],
                $ward
            );
        }
    }
}
