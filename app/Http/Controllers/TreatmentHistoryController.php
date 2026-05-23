<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\MedicalRecord;
 
class TreatmentHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = MedicalRecord::query();
 
        if ($request->month) {
            $query->whereMonth('treatment_datetime', $request->month);
        }
        if ($request->year) {
            $query->whereYear('treatment_datetime', $request->year);
        }
 
        $records = $query->latest('treatment_datetime')->get();
        $years = MedicalRecord::selectRaw('EXTRACT(YEAR FROM treatment_datetime) as year')
            ->distinct()->orderByDesc('year')->pluck('year');
 
        return view('treatment-history', compact('records', 'years'));
    }
}
