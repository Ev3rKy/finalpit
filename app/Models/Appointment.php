<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Appointment extends Model
{
    protected $fillable = [
        'full_name', 'age', 'birth_date', 'religion',
        'complete_address', 'phone_no', 'email_acc',
        'appointment_date', 'appointment_time',
        'medical_department', 'doctor',
    ];
}
