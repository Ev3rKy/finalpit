<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Ward;
use Illuminate\Http\Request;

class BillController extends Controller
{
    // ── LIST ─────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Bill::with('ward')->latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('patient_name', 'ilike', "%{$search}%")
                  ->orWhere('bill_no', 'ilike', "%{$search}%")
                  ->orWhere('patient_id', 'ilike', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $bills    = $query->paginate(15)->withQueryString();
        $allCount = Bill::count();

        return view('bills.index', compact('bills', 'allCount'));
    }

    // ── SHOW ─────────────────────────────────────────────────────────────────
    public function show(Bill $bill)
    {
        $bill->load('ward');
        return view('bills.show', compact('bill'));
    }

    // ── CREATE FORM ───────────────────────────────────────────────────────────
    public function create()
    {
        $wards      = Ward::orderBy('name')->get();
        $services   = $this->serviceList();
        $nextBillNo = Bill::nextBillNo();
        return view('bills.create', compact('wards', 'services', 'nextBillNo'));
    }

    // ── STORE ─────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_id'   => 'required|string|max:50',
            'ward_id'      => 'required|exists:wards,id',
            'service'      => 'required|string|max:255',
            'amount'       => 'required|integer|min:1',
            'due_date'     => 'nullable|date',
            'status'       => 'required|in:pending,paid,overdue',
        ]);

        $validated['bill_no'] = Bill::nextBillNo();

        if ($validated['status'] === 'paid') {
            $validated['paid_at'] = now();
        }

        Bill::create($validated);

        return redirect()->route('bills.index')
            ->with('success', $validated['bill_no'] . ' created for ' . $validated['patient_name'] . '!');
    }

    // ── EDIT FORM ─────────────────────────────────────────────────────────────
    public function edit(Bill $bill)
    {
        $wards    = Ward::orderBy('name')->get();
        $services = $this->serviceList();
        return view('bills.edit', compact('bill', 'wards', 'services'));
    }

    // ── UPDATE ────────────────────────────────────────────────────────────────
    public function update(Request $request, Bill $bill)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_id'   => 'required|string|max:50',
            'ward_id'      => 'required|exists:wards,id',
            'service'      => 'required|string|max:255',
            'amount'       => 'required|integer|min:1',
            'due_date'     => 'nullable|date',
            'status'       => 'required|in:pending,paid,overdue',
        ]);

        if ($validated['status'] === 'paid' && $bill->status !== 'paid') {
            $validated['paid_at'] = now();
        } elseif ($validated['status'] !== 'paid') {
            $validated['paid_at'] = null;
        }

        $bill->update($validated);

        return redirect()->route('bills.index')
            ->with('success', $bill->bill_no . ' updated successfully.');
    }

    // ── DELETE ────────────────────────────────────────────────────────────────
    public function destroy(Bill $bill)
    {
        $billNo = $bill->bill_no;
        $bill->delete();

        return redirect()->route('bills.index')
            ->with('success', $billNo . ' deleted successfully.');
    }

    // ── MARK PAID ─────────────────────────────────────────────────────────────
    public function markPaid(Bill $bill)
    {
        if ($bill->status !== 'paid') {
            $bill->update(['status' => 'paid', 'paid_at' => now()]);
        }
        return back()->with('success', $bill->bill_no . ' marked as paid.');
    }

    // ── OUTSTANDING ───────────────────────────────────────────────────────────
    public function outstanding()
    {
        $bills = Bill::with('ward')
            ->unpaid()
            ->orderByRaw("CASE status WHEN 'overdue' THEN 0 ELSE 1 END")
            ->orderBy('due_date')
            ->get();

        $unpaidCount    = $bills->count();
        $outstandingAmt = $bills->sum('amount');

        return view('bills.outstanding', compact('bills', 'unpaidCount', 'outstandingAmt'));
    }

    // ── HELPERS ───────────────────────────────────────────────────────────────
    private function serviceList(): array
    {
        return [
            'Room + Treatment',
            'Surgery + Room',
            'Services + Meds',
            'Consultation',
            'Emergency',
            'Medicines',
            'Post-op Care',
            'Follow-up',
        ];
    }
}
