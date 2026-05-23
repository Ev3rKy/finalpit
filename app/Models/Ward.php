<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ward extends Model
{
    protected $fillable = ['name', 'total_beds', 'occupied_beds'];

    public function bills(): HasMany
    {
        return $this->hasMany(Bill::class);
    }

    public function getOccupancyRateAttribute(): int
    {
        if ($this->total_beds === 0) return 0;
        return (int) round(($this->occupied_beds / $this->total_beds) * 100);
    }

    public function getAvailableBedsAttribute(): int
    {
        return $this->total_beds - $this->occupied_beds;
    }
}
