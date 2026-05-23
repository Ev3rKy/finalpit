<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    protected $fillable = [
        'patient_id', 'drug_number', 'drug_name', 'description',
        'dosage', 'method_of_admin', 'units_per_day',
        'start_date', 'finish_date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}