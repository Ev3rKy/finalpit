<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Staff;
 
class AuthController extends Controller
{
    public function showLogin()
    {
        if (session('staff_id')) return redirect()->route('dashboard');
        return view('auth.login');
    }
 
    public function login(Request $request)
    {
        $request->validate([
            'staff_id_code' => 'required',
            'password' => 'required',
        ]);
 
        $staff = Staff::where('staff_id_code', $request->staff_id_code)->first();
 
        if ($staff && Hash::check($request->password, $staff->password)) {
            session(['staff_id' => $staff->id, 'staff_name' => $staff->full_name]);
            return redirect()->route('dashboard');
        }
 
        return back()->withErrors(['staff_id_code' => 'Invalid credentials.']);
    }
 
    public function showSignin()
    {
        return view('auth.signin');
    }
 
    public function signin(Request $request)
    {
        $request->validate([
            'full_name'      => 'required|string|max:255',
            'staff_id_code'  => 'required|string|unique:staff,staff_id_code',
            'email'          => 'required|email|unique:staff,email',
            'password'       => 'required|min:6|confirmed',
        ]);
 
        Staff::create([
            'full_name'     => $request->full_name,
            'staff_id_code' => $request->staff_id_code,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
        ]);
 
        return redirect()->route('login')->with('success', 'Account created! You may now log in.');
    }
 
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login');
    }
}
