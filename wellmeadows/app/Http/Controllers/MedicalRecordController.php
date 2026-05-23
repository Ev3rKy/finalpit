<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Medication;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function patientList()
    {
        $patients = Patient::latest()->get();
        return view('patients.medical_index', compact('patients'));
    }

    public function index($patientId)
{
    $patient = Patient::with(['medicalRecord', 'medications', 'admissions'])->findOrFail($patientId);
    $medications = $patient->medications()->latest()->take(3)->get();
    $admission = $patient->admissions()->whereNull('date_actually_left')->latest()->first();
    return view('patients.medical', compact('patient', 'medications', 'admission'));
}

    public function store(Request $request)
    {
        $request->validate([
            'patient_id'  => 'required',
            'drug_number' => 'required',
            'drug_name'   => 'required',
            'start_date'  => 'required|date',
        ]);

        Medication::create($request->except('_token'));
        return redirect()->back()->with('success', 'Medication added successfully!');
    }

    public function wardIndex()
    {
        $patients = Patient::with('medicalRecord')->latest()->get();
        $totalBeds = 240;
        $occupied = MedicalRecord::whereNull('date_actually_left')->count();
        $vacant = $totalBeds - $occupied;
        $waitingList = Patient::where('status', 'IN-PATIENT')
            ->whereDoesntHave('medicalRecord')
            ->count();

        return view('patients.ward', compact('patients', 'totalBeds', 'occupied', 'vacant', 'waitingList'));
    }

    public function wardStore(Request $request)
    {
        $request->validate([
            'patient_id'   => 'required',
            'ward_number'  => 'required',
            'ward_name'    => 'required',
            'bed_number'   => 'required',
            'date_placed'  => 'required|date',
        ]);

        MedicalRecord::updateOrCreate(
            ['patient_id' => $request->patient_id],
            [
                'ward_number'         => $request->ward_number,
                'ward_name'           => $request->ward_name,
                'bed_number'          => $request->bed_number,
                'date_placed'         => $request->date_placed,
                'expected_stay'       => $request->expected_stay,
                'date_expected_leave' => $request->date_expected_leave,
                'date_actually_left'  => $request->date_actually_left,
            ]
        );

        // Update patient status to IN-PATIENT
        Patient::find($request->patient_id)->update(['status' => 'IN-PATIENT']);

        return redirect()->back()->with('success', 'Ward assignment saved successfully!');
    }
}