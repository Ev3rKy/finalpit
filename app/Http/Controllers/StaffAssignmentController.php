<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\StaffTask;
use App\Models\Staff;
 
class StaffAssignmentController extends Controller
{
    public function index(Request $request)
    {
        $tasks = StaffTask::latest()->get();
 
        $doctorSearch = $request->doctor_search ?? '';
        $nurseSearch  = $request->nurse_search ?? '';
 
        // Get names already assigned (not completed)
        $assignedStaff = StaffTask::where('is_completed', false)->pluck('assigned_staff')->toArray();
 
        $doctors = Staff::where('role', 'doctor')
            ->when($doctorSearch, fn($q) => $q->where('full_name', 'ilike', "%$doctorSearch%"))
            ->get()
            ->filter(fn($s) => !in_array($s->full_name, $assignedStaff));
 
        $nurses = Staff::where('role', 'nurse')
            ->when($nurseSearch, fn($q) => $q->where('full_name', 'ilike', "%$nurseSearch%"))
            ->get()
            ->filter(fn($s) => !in_array($s->full_name, $assignedStaff));
 
        return view('assign-staff', compact('tasks', 'doctors', 'nurses'));
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'patient_full_name' => 'required|string',
            'treatment_type'    => 'required|string',
            'assigned_staff'    => 'required|string',
        ]);
 
        // Determine if doctor or nurse
        $staff = Staff::where('full_name', $request->assigned_staff)->first();
        $staffType = $staff ? $staff->role : 'doctor';
 
        StaffTask::create([
            'patient_full_name' => $request->patient_full_name,
            'treatment_type'    => $request->treatment_type,
            'assigned_staff'    => $request->assigned_staff,
            'staff_type'        => $staffType,
        ]);
 
        return back()->with('success', 'Task assigned.');
    }
 
    public function toggleTask($id)
    {
    $task = StaffTask::findOrFail($id);
    
    if ($task->is_completed) {
        // If already done, uncheck it
        $task->is_completed = false;
        $task->save();
    } else {
        // Mark as done then delete it
        $task->delete();
    }
    
    return back();
    }
}
