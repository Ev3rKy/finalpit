<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $table = 'ward';

    public function getTable(): string
    {
        return 'ward';
    }

    protected $primaryKey = 'ward_number';

    public $incrementing = false;

    protected $keyType = 'int';

    protected $fillable = [
        'ward_number',
        'ward_name',
        'location',
        'total_beds',
        'tel_extn',
    ];
}
