<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\StaffQualification;
use App\Models\StaffWorkExperience;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    // Show staff list
    public function index()
    {
        $staff = Staff::all();
        return view('staff.index', compact('staff'));
    }

    // Show add form
    public function create()
    {
        return view('staff.create');
    }

    // Save new staff
    public function store(Request $request)
    {
        $request->validate([
            'staff_number'   => 'required|unique:staff',
            'first_name'     => 'required',
            'last_name'      => 'required',
            'nin'            => 'required|unique:staff',
            'position'       => 'required',
            'current_salary' => 'required|numeric',
            'contract_type'  => 'required',
            'dob'            => 'required|date',
            'sex'            => 'required',
            'address'        => 'required',
        ]);

        Staff::create($request->all());

        return redirect()->route('staff.index')
            ->with('success', 'Staff member added successfully!');
    }

    // Show staff profile
    public function show($staff_number)
    {
        $staff = Staff::with(['qualifications', 'workExperiences'])
                      ->findOrFail($staff_number);
        return view('staff.show', compact('staff'));
    }

    // Show edit form
    public function edit($staff_number)
    {
        $staff = Staff::findOrFail($staff_number);
        return view('staff.edit', compact('staff'));
    }

    // Update staff
    public function update(Request $request, $staff_number)
    {
        $staff = Staff::findOrFail($staff_number);
        $staff->update($request->all());

        return redirect()->route('staff.show', $staff_number)
            ->with('success', 'Staff updated successfully!');
    }

    // Delete staff
    public function destroy($staff_number)
    {
        Staff::findOrFail($staff_number)->delete();

        return redirect()->route('staff.index')
            ->with('success', 'Staff member deleted!');
    }

    // Add qualification
    public function addQualification(Request $request, $staff_number)
    {
        StaffQualification::create([
            'staff_number'       => $staff_number,
            'qualification_type' => $request->qualification_type,
            'date_obtained'      => $request->date_obtained,
            'institution'        => $request->institution,
        ]);

        return redirect()->route('staff.show', $staff_number)
            ->with('success', 'Qualification added!');
    }

    // Add work experience
    public function addExperience(Request $request, $staff_number)
    {
        StaffWorkExperience::create([
            'staff_number' => $staff_number,
            'position'     => $request->position,
            'start_date'   => $request->start_date,
            'finish_date'  => $request->finish_date,
            'organisation' => $request->organisation,
        ]);

        return redirect()->route('staff.show', $staff_number)
            ->with('success', 'Work experience added!');
    }
}