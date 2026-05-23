<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Models\Staff;
 
class MedicalRecordController extends Controller
{
    public function index()
    {
        $doctors = Staff::where('role', 'doctor')->get();
        return view('medical-record', compact('doctors'));
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'patient_full_name'   => 'required|string|max:255',
            'doctor'              => 'required|string',
            'treatment_datetime'  => 'required',
            'procedure'           => 'required|string',
        ]);
 
        MedicalRecord::create($request->only([
            'patient_full_name', 'age', 'birth_date', 'religion',
            'complete_address', 'phone_no', 'doctor',
            'treatment_datetime', 'procedure',
            'bp', 'temperature', 'spo2', 'medical_notes',
        ]));
 
        return back()->with('success', 'Medical record saved.');
    }
}
