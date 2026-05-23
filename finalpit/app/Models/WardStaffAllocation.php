<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WardStaffAllocation extends Model
{
    protected $table = 'ward_staff_allocation';

    protected $primaryKey = 'allocation_id';

    protected $fillable = [
        'staff_number', 'ward_number',
        'week_start_date', 'shift'
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_number', 'staff_number');
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_number', 'ward_number');
    }
}