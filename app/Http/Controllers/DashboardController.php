<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Ward;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Metric cards
        $totalRevenue   = Bill::paid()->sum('amount');
        $billCount      = Bill::count();
        $outstandingAmt = Bill::unpaid()->sum('amount');
        $unpaidCount    = Bill::unpaid()->count();

        // Occupancy
        $totalBeds    = Ward::sum('total_beds');
        $occupiedBeds = Ward::sum('occupied_beds');
        $occupancyPct = $totalBeds > 0 ? round(($occupiedBeds / $totalBeds) * 100) : 0;

        // Recent bills (last 8)
        $recentBills = Bill::with('ward')->latest()->take(8)->get();

        // Outstanding bills table (unpaid, most urgent first)
        $outstandingBills = Bill::with('ward')
            ->unpaid()
            ->orderByRaw("CASE status WHEN 'overdue' THEN 0 ELSE 1 END")
            ->orderBy('due_date')
            ->take(10)
            ->get();

        return view('dashboard', compact(
            'totalRevenue', 'billCount', 'outstandingAmt', 'unpaidCount',
            'totalBeds', 'occupiedBeds', 'occupancyPct',
            'recentBills', 'outstandingBills'
        ));
    }
}
