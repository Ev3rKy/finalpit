<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class StaffTask extends Model
{
    protected $fillable = [
        'patient_full_name', 'treatment_type',
        'assigned_staff', 'staff_type', 'is_completed',
    ];
}
