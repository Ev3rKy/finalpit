<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\Appointment;
 
class AppointmentController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();
        $startOfNextMonth = now()->startOfMonth()->addMonth()->toDateString();
        
        // Remove appointments older than this month
        Appointment::where('appointment_date', '<', now()->startOfMonth()->toDateString())->delete();
        
        $appointments = Appointment::latest()->get();
        return view('appointment', compact('appointments', 'today'));
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'full_name'          => 'required|string|max:255',
            'appointment_date'   => 'required|date',
            'appointment_time'   => 'required',
            'medical_department' => 'required|string',
            'doctor'             => 'required|string',
        ]);
 
        Appointment::create($request->only([
            'full_name', 'age', 'birth_date', 'religion',
            'complete_address', 'phone_no', 'email_acc',
            'appointment_date', 'appointment_time',
            'medical_department', 'doctor',
        ]));
 
        return back()->with('success', 'Appointment scheduled successfully.');
    }
}
