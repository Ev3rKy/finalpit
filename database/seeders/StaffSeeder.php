<?php

namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Staff;
 
class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $staff = [
            // Doctors
            ['full_name' => 'Dr. Bonilla',    'staff_id_code' => 'DR001', 'email' => 'bonilla@wellmeadows.com',    'role' => 'doctor', 'specialty' => 'Neurologist'],
            ['full_name' => 'Dr. Cabangbang',  'staff_id_code' => 'DR002', 'email' => 'cabangbang@wellmeadows.com', 'role' => 'doctor', 'specialty' => 'Orthopedist'],
            ['full_name' => 'Dr. Lacson',      'staff_id_code' => 'DR003', 'email' => 'lacson@wellmeadows.com',     'role' => 'doctor', 'specialty' => 'Dermatologist'],
            ['full_name' => 'Dr. Bello',       'staff_id_code' => 'DR004', 'email' => 'bello@wellmeadows.com',      'role' => 'doctor', 'specialty' => 'Cardiologist'],
            ['full_name' => 'Dr. Pausanos',    'staff_id_code' => 'DR005', 'email' => 'pausanos@wellmeadows.com',   'role' => 'doctor', 'specialty' => 'Ophthalmologist'],
            // Nurses
            ['full_name' => 'Nr. Bonilla',    'staff_id_code' => 'NR001', 'email' => 'nbonilla@wellmeadows.com',    'role' => 'nurse', 'specialty' => 'ER Nurse'],
            ['full_name' => 'Nr. Cabangbang',  'staff_id_code' => 'NR002', 'email' => 'ncabangbang@wellmeadows.com', 'role' => 'nurse', 'specialty' => 'ER Nurse'],
            ['full_name' => 'Nr. Lacson',      'staff_id_code' => 'NR003', 'email' => 'nlacson@wellmeadows.com',     'role' => 'nurse', 'specialty' => 'OR Nurse'],
            ['full_name' => 'Nr. Bello',       'staff_id_code' => 'NR004', 'email' => 'nbello@wellmeadows.com',      'role' => 'nurse', 'specialty' => 'ICU Nurse'],
            ['full_name' => 'Nr. Pausanos',    'staff_id_code' => 'NR005', 'email' => 'npausanos@wellmeadows.com',   'role' => 'nurse', 'specialty' => 'ICU Nurse'],
        ];
 
        foreach ($staff as $s) {
            Staff::create(array_merge($s, ['password' => Hash::make('password123')]));
        }
    }
}
