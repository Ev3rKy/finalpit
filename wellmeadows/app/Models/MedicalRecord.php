<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $fillable = [
        'patient_id', 'ward_number', 'ward_name', 'bed_number',
        'date_placed', 'expected_stay', 'date_expected_leave', 'date_actually_left',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}