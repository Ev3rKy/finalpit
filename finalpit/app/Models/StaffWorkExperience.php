<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffWorkExperience extends Model
{
    protected $table = 'staff_work_experience';

    protected $primaryKey = 'experience_id';

    protected $fillable = [
        'staff_number',
        'position',
        'start_date',
        'finish_date',
        'organisation',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_number', 'staff_number');
    }
}
