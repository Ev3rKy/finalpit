<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Bill extends Model
{
    protected $fillable = [
        'bill_no', 'patient_name', 'patient_id',
        'ward_id', 'service', 'amount',
        'due_date', 'status', 'paid_at',
    ];

    protected $casts = [
        'due_date' => 'date',
        'paid_at'  => 'datetime',
        'amount'   => 'integer',
    ];

    // ── Relationships ─────────────────────────────────────────────────────────
    public function ward(): BelongsTo
    {
        return $this->belongsTo(Ward::class);
    }

    // ── Helpers ──────────────────────────────────────────────────────────────
    public static function nextBillNo(): string
    {
        $last = static::latest('id')->value('bill_no');
        if (!$last) return '#BL-2025';
        $num = (int) Str::afterLast($last, '-');
        return '#BL-' . ($num + 1);
    }

    public function getInitialsAttribute(): string
    {
        return collect(explode(' ', $this->patient_name))
            ->map(fn($w) => strtoupper($w[0] ?? ''))
            ->take(2)
            ->join('');
    }

    public function getFormattedAmountAttribute(): string
    {
        return '₱' . number_format($this->amount);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'paid'    => '<span class="badge b-green">Paid</span>',
            'overdue' => '<span class="badge b-red">Overdue</span>',
            default   => '<span class="badge b-amber">Pending</span>',
        };
    }

    // ── Scopes ──────────────────────────────────────────────────────────────
    public function scopeUnpaid($query)
    {
        return $query->whereIn('status', ['pending', 'overdue']);
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }
}
