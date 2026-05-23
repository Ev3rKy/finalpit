<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staff';

    protected $primaryKey = 'staff_number';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'staff_number', 'first_name', 'last_name', 'address',
        'tel_no', 'dob', 'sex', 'nin', 'position', 'current_salary',
        'salary_scale', 'hours_per_week', 'contract_type',
        'payment_type', 'allocated_ward'
    ];

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'allocated_ward', 'ward_number');
    }

    public function qualifications()
    {
        return $this->hasMany(StaffQualification::class, 'staff_number', 'staff_number');
    }

    public function workExperiences()
    {
        return $this->hasMany(StaffWorkExperience::class, 'staff_number', 'staff_number');
    }

    public function allocations()
    {
        return $this->hasMany(WardStaffAllocation::class, 'staff_number', 'staff_number');
    }
}