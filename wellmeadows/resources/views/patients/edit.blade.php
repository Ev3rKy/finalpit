@extends('layouts.app')

@section('content')

<div class="topbar">
    <h2>Edit Patient</h2>
    <div class="topbar-actions">
        <a href="{{ route('patients.index') }}" class="btn btn-outline" style="font-size:12px;">← Back to Patients</a>
    </div>
</div>

<div class="content">

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div style="background:white; border-radius:12px; padding:32px; max-width:900px; margin:0 auto;">
        <h3 style="color:#1a1f5e; font-size:16px; font-weight:700; margin-bottom:24px;">
            Editing — {{ $patient->first_name }} {{ $patient->last_name }}
            <span style="color:#888; font-weight:400; font-size:13px; margin-left:8px;">{{ $patient->patient_no }}</span>
        </h3>

        <form method="POST" action="{{ route('patients.update', $patient->id) }}">
            @csrf
            @method('PATCH')
            <div class="form-grid">

                <div class="form-section-title">Personal Information</div>

                <div class="form-group">
                    <label>First Name *</label>
                    <input type="text" name="first_name" value="{{ $patient->first_name }}" required>
                </div>
                <div class="form-group">
                    <label>Last Name *</label>
                    <input type="text" name="last_name" value="{{ $patient->last_name }}" required>
                </div>
                <div class="form-group full">
                    <label>Address *</label>
                    <input type="text" name="address" value="{{ $patient->address }}" required>
                </div>
                <div class="form-group">
                    <label>Tel No.</label>
                    <input type="text" name="tel_no" value="{{ $patient->tel_no }}">
                </div>
                <div class="form-group">
                    <label>Sex *</label>
                    <select name="sex" required>
                        <option value="Male" {{ $patient->sex == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $patient->sex == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Date of Birth *</label>
                    <input type="date" name="date_of_birth" value="{{ $patient->date_of_birth }}" required>
                </div>
                <div class="form-group">
                    <label>Marital Status</label>
                    <select name="marital_status">
                        <option value="">Select</option>
                        <option value="Single" {{ $patient->marital_status == 'Single' ? 'selected' : '' }}>Single</option>
                        <option value="Married" {{ $patient->marital_status == 'Married' ? 'selected' : '' }}>Married</option>
                        <option value="Widowed" {{ $patient->marital_status == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                        <option value="Divorced" {{ $patient->marital_status == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Date Registered</label>
                    <input type="date" name="date_registered" value="{{ $patient->date_registered }}">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="OUT-PATIENT" {{ $patient->status == 'OUT-PATIENT' ? 'selected' : '' }}>OUT-PATIENT</option>
                        <option value="IN-PATIENT" {{ $patient->status == 'IN-PATIENT' ? 'selected' : '' }}>IN-PATIENT</option>
                    </select>
                </div>

                <div class="form-section-title">Next of Kin</div>

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="kin_full_name" value="{{ $patient->kin_full_name }}" style="background:#fff5f5;">
                </div>
                <div class="form-group">
                    <label>Relationship</label>
                    <input type="text" name="kin_relationship" value="{{ $patient->kin_relationship }}" style="background:#fff5f5;">
                </div>
                <div class="form-group full">
                    <label>Address</label>
                    <input type="text" name="kin_address" value="{{ $patient->kin_address }}">
                </div>
                <div class="form-group">
                    <label>Tel No.</label>
                    <input type="text" name="kin_tel_no" value="{{ $patient->kin_tel_no }}">
                </div>

                <div class="form-section-title">Local Doctor Details</div>

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="doctor_full_name" value="{{ $patient->doctor_full_name }}">
                </div>
                <div class="form-group">
                    <label>Clinic / Tel No.</label>
                    <input type="text" name="doctor_clinic_tel" value="{{ $patient->doctor_clinic_tel }}">
                </div>
                <div class="form-group full">
                    <label>Address</label>
                    <input type="text" name="doctor_address" value="{{ $patient->doctor_address }}">
                </div>

            </div>

            <div class="form-actions">
                <a href="{{ route('patients.index') }}" class="btn btn-outline" style="color:#666; border-color:#ddd;">Cancel</a>
                <button type="submit" class="btn btn-blue">Save Changes</button>
            </div>
        </form>
    </div>
</div>

@endsection