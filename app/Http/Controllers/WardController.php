<?php

namespace App\Http\Controllers;

use App\Models\Ward;
use Illuminate\Http\Request;

class WardController extends Controller
{
    public function index()
    {
        $wards = Ward::withCount('bills')->orderBy('name')->get();
        return view('wards.index', compact('wards'));
    }

    public function create()
    {
        return view('wards.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:100|unique:wards,name',
            'total_beds'    => 'required|integer|min:1',
            'occupied_beds' => 'required|integer|min:0',
        ]);

        if ($validated['occupied_beds'] > $validated['total_beds']) {
            return back()->withErrors(['occupied_beds' => 'Occupied beds cannot exceed total beds.'])->withInput();
        }

        Ward::create($validated);

        return redirect()->route('wards.index')
            ->with('success', $validated['name'] . ' created successfully.');
    }

    public function edit(Ward $ward)
    {
        return view('wards.edit', compact('ward'));
    }

    public function update(Request $request, Ward $ward)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:100|unique:wards,name,' . $ward->id,
            'total_beds'    => 'required|integer|min:1',
            'occupied_beds' => 'required|integer|min:0',
        ]);

        if ($validated['occupied_beds'] > $validated['total_beds']) {
            return back()->withErrors(['occupied_beds' => 'Occupied beds cannot exceed total beds.'])->withInput();
        }

        $ward->update($validated);

        return redirect()->route('wards.index')
            ->with('success', $ward->name . ' updated successfully.');
    }

    public function destroy(Ward $ward)
    {
        if ($ward->bills()->exists()) {
            return back()->with('error', 'Cannot delete ' . $ward->name . ' — it has bills attached.');
        }

        $name = $ward->name;
        $ward->delete();

        return redirect()->route('wards.index')
            ->with('success', $name . ' deleted successfully.');
    }
}
