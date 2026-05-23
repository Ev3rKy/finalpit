<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    protected $fillable = [
        'patient_id', 'patient_no', 'ward_required', 'bed_number',
        'date_placed_waiting', 'expected_stay', 'date_placed_ward',
        'date_expected_leave', 'type',
        'date_actually_left', 'discharge_type', 'discharge_notes',
        'followup_appointment', 'medications_on_discharge',
        'appointment_number', 'clinic_date_time', 'consultant', 'examination_room',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}