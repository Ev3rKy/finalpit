<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'patient_no', 'first_name', 'last_name', 'address',
        'tel_no', 'sex', 'date_of_birth', 'marital_status',
        'date_registered', 'status',
        'kin_full_name', 'kin_relationship', 'kin_address', 'kin_tel_no',
        'doctor_full_name', 'doctor_clinic_tel', 'doctor_address',
    ];

    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class);
    }

    public function medications()
    {
        return $this->hasMany(Medication::class);
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class);
    }
}