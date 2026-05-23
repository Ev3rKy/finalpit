<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffQualification extends Model
{
    protected $table = 'staff_qualification';

    protected $primaryKey = 'qualification_id';

    protected $fillable = [
        'staff_number', 'qualification_type',
        'date_obtained', 'institution'
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_number', 'staff_number');
    }
}