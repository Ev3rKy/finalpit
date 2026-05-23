<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Patient;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    public function index()
    {
        $admissions = Admission::with('patient')->latest()->get();
        $inPatients = Admission::whereNull('date_actually_left')->where('type', 'IN-PATIENT')->count();
        $dischargedToday = Admission::whereDate('date_actually_left', today())->count();
        $avgStay = Admission::whereNotNull('expected_stay')->avg('expected_stay');
        $outPatients = Admission::where('type', 'OUT-PATIENT')->count();
        $patients = Patient::all();
        $waitingList = Admission::whereNull('date_placed_ward')->whereNull('date_actually_left')->count();

        return view('patients.admission', compact(
            'admissions', 'inPatients', 'dischargedToday',
            'avgStay', 'outPatients', 'patients', 'waitingList'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'type'       => 'required',
        ]);

        $patient = Patient::findOrFail($request->patient_id);

        Admission::create(array_merge(
            $request->except('_token'),
            ['patient_no' => $patient->patient_no]
        ));

        // Update patient status
        $patient->update(['status' => $request->type]);

        return redirect()->back()->with('success', 'Admission recorded successfully!');
    }

    public function discharge(Request $request, $id)
    {
        $admission = Admission::findOrFail($id);
        $admission->update([
            'date_actually_left'       => $request->date_actually_left,
            'discharge_type'           => $request->discharge_type,
            'discharge_notes'          => $request->discharge_notes,
            'followup_appointment'     => $request->followup_appointment,
            'medications_on_discharge' => $request->medications_on_discharge,
            'appointment_number'       => $request->appointment_number,
            'clinic_date_time'         => $request->clinic_date_time,
            'consultant'               => $request->consultant,
            'examination_room'         => $request->examination_room,
        ]);

        // Update patient status to OUT-PATIENT after discharge
        $admission->patient->update(['status' => 'OUT-PATIENT']);

        return redirect()->back()->with('success', 'Patient discharged successfully!');
    }
}