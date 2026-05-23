<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class MedicalRecord extends Model
{
    protected $fillable = [
        'patient_full_name', 'age', 'birth_date', 'religion',
        'complete_address', 'phone_no', 'doctor',
        'treatment_datetime', 'procedure',
        'bp', 'temperature', 'spo2', 'medical_notes',
    ];
 
    protected $casts = [
        'treatment_datetime' => 'datetime',
    ];
}
