<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::latest()->get();
        $totalPatients = Patient::count();
        $registeredThisMonth = Patient::whereMonth('date_registered', now()->month)->count();
        $outPatients = Patient::where('status', 'OUT-PATIENT')->count();
        $inPatients = Patient::where('status', 'IN-PATIENT')->count();

        return view('patients.index', compact(
            'patients', 'totalPatients',
            'registeredThisMonth', 'outPatients', 'inPatients'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'       => 'required',
            'last_name'        => 'required',
            'address'          => 'required',
            'sex'              => 'required',
            'date_of_birth'    => 'required|date',
            'date_registered'  => 'required|date',
        ]);

        $latest = Patient::latest('id')->first();
        $nextId = $latest ? $latest->id + 1 : 1;
        $patientNo = 'P' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

        Patient::create(array_merge(
            $request->except('_token'),
            ['patient_no' => $patientNo]
        ));

        return redirect()->route('patients.index')->with('success', 'Patient registered successfully!');
    }

    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);
        $patient->update($request->except('_token', '_method'));
        return redirect()->route('patients.index')->with('success', 'Patient updated successfully!');
    }

    public function destroy($id)
    {
        Patient::destroy($id);;
        return redirect()->route('patients.index')->with('success', 'Patient archived successfully!');
    }
}