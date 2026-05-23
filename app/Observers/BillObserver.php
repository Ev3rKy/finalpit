<?php

namespace App\Observers;

use App\Models\Bill;
use App\Models\Ward;

class BillObserver
{
    public function created(Bill $bill): void
    {
        $this->syncWard($bill->ward_id);
    }

    public function updated(Bill $bill): void
    {
        // If ward changed, sync both old and new ward
        if ($bill->wasChanged('ward_id')) {
            $this->syncWard($bill->getOriginal('ward_id'));
        }
        $this->syncWard($bill->ward_id);
    }

    public function deleted(Bill $bill): void
    {
        $this->syncWard($bill->ward_id);
    }

    private function syncWard(int $wardId): void
    {
        $ward = Ward::find($wardId);
        if (!$ward) return;

        // Occupied = number of active (pending/overdue) bills in this ward
        $occupied = Bill::where('ward_id', $wardId)
            ->whereIn('status', ['pending', 'overdue'])
            ->count();

        $ward->update(['occupied_beds' => $occupied]);
    }
}