<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Ward;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function revenue()
    {
        // Revenue breakdown by service category (group by service keyword)
        $rawRevenue = Bill::paid()
            ->selectRaw('service, SUM(amount) as total')
            ->groupBy('service')
            ->orderByDesc('total')
            ->get();

        // Bucket into 4 categories
        $buckets = ['Room fees' => 0, 'Treatments' => 0, 'Services' => 0, 'Medicines' => 0];
        foreach ($rawRevenue as $row) {
            $s = strtolower($row->service);
            if (str_contains($s, 'room'))      $buckets['Room fees']   += $row->total;
            elseif (str_contains($s, 'surge') || str_contains($s, 'treat') || str_contains($s, 'emergency') || str_contains($s, 'post') || str_contains($s, 'care'))
                                               $buckets['Treatments']  += $row->total;
            elseif (str_contains($s, 'service') || str_contains($s, 'consult') || str_contains($s, 'follow'))
                                               $buckets['Services']    += $row->total;
            else                               $buckets['Medicines']   += $row->total;
        }

        $subtotal = array_sum($buckets);
        $discount = (int) round($subtotal * 0.025);   // 2.5% discount (seeded assumption)
        $net      = $subtotal - $discount;
        $maxVal   = max(array_values($buckets)) ?: 1;

        return view('reports.revenue', compact('buckets', 'subtotal', 'discount', 'net', 'maxVal'));
    }

    public function occupancy()
    {
        $wards        = Ward::orderBy('name')->get();
        $totalBeds    = $wards->sum('total_beds');
        $occupiedBeds = $wards->sum('occupied_beds');
        $availBeds    = $totalBeds - $occupiedBeds;
        $rate         = $totalBeds > 0 ? round(($occupiedBeds / $totalBeds) * 100) : 0;

        return view('reports.occupancy', compact('wards', 'totalBeds', 'occupiedBeds', 'availBeds', 'rate'));
    }

    public function summaries()
    {
        $totalPatients  = Bill::count();
        $collected      = Bill::paid()->sum('amount');
        $avgBill        = $totalPatients > 0 ? round($collected / $totalPatients) : 0;
        $paidCount      = Bill::paid()->count();
        $collectionRate = $totalPatients > 0 ? round(($paidCount / $totalPatients) * 100) : 0;

        $wards       = Ward::orderBy('name')->get();
        $fullWards   = $wards->where('occupied_beds', '>=', 'total_beds');

        $unpaidCount    = Bill::unpaid()->count();
        $outstandingAmt = Bill::unpaid()->sum('amount');

        return view('reports.summaries', compact(
            'totalPatients', 'collected', 'avgBill', 'collectionRate',
            'wards', 'unpaidCount', 'outstandingAmt'
        ));
    }

    public function export()
    {
        return view('reports.export');
    }

    public function download(Request $request)
    {
        $type = $request->query('type', 'csv');

        if ($type === 'csv') {
            $bills = Bill::with('ward')->latest()->get();

            $headers = [
                'Content-Type'        => 'text/csv',
                'Content-Disposition' => 'attachment; filename="wellmeadows_bills_' . now()->format('Y-m-d') . '.csv"',
            ];

            $callback = function () use ($bills) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['Bill No', 'Patient Name', 'Patient ID', 'Ward', 'Service', 'Amount (₱)', 'Due Date', 'Status', 'Paid At']);
                foreach ($bills as $b) {
                    fputcsv($handle, [
                        $b->bill_no,
                        $b->patient_name,
                        $b->patient_id,
                        $b->ward->name ?? '',
                        $b->service,
                        $b->amount,
                        $b->due_date?->format('Y-m-d') ?? '',
                        $b->status,
                        $b->paid_at?->format('Y-m-d H:i') ?? '',
                    ]);
                }
                fclose($handle);
            };

            return response()->stream($callback, 200, $headers);
        }

        // PDF — redirect back with toast (real PDF needs a package like barryvdh/laravel-dompdf)
        return redirect()->route('reports.export')->with('success', 'PDF export requires the dompdf package. Run: composer require barryvdh/laravel-dompdf');
    }
}
