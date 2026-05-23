<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Ward;
use App\Models\WardStaffAllocation;
use Illuminate\Http\Request;

class WardAllocationController extends Controller
{
    public function index()
    {
        $allocations = WardStaffAllocation::with('staff')
            ->orderByDesc('week_start_date')
            ->get();

        $wards = Ward::query()->from('ward')->orderBy('ward_number')->get();
        $staffList = Staff::query()->from('staff')->orderBy('first_name')->get();
        $weeks = WardStaffAllocation::query()
            ->select('week_start_date')
            ->distinct()
            ->orderByDesc('week_start_date')
            ->pluck('week_start_date');

        $selectedWard = $wards->first();

        return view('ward-allocation.index', compact(
            'allocations',
            'staffList',
            'wards',
            'weeks',
            'selectedWard'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'staff_number'     => 'required|exists:staff,staff_number',
            'ward_number'      => 'required|integer|exists:ward,ward_number',
            'week_start_date'  => 'required|date',
            'shift'            => 'required|in:Early,Late,Night',
        ]);

        WardStaffAllocation::create($request->only([
            'staff_number',
            'ward_number',
            'week_start_date',
            'shift',
        ]));

        return redirect()
            ->route('ward-allocation.index')
            ->with('success', 'Staff assigned to ward successfully!');
    }

    public function destroy(string $ward_allocation)
    {
        WardStaffAllocation::where('allocation_id', $ward_allocation)->delete();

        return redirect()
            ->route('ward-allocation.index')
            ->with('success', 'Assignment removed.');
    }
}
