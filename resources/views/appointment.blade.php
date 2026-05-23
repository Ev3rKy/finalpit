@extends('layouts.app')
 
@section('content')
<div style="display:grid; grid-template-columns:1fr 1.4fr; gap:24px; max-width:1100px; margin:0 auto;">
 
    {{-- SCHEDULE PANEL --}}
    <div class="card">
        <div class="card-title">Schedule</div>
 
        @forelse($appointments as $appt)
            @php
                $date = \Carbon\Carbon::parse($appt->appointment_date);
                $dayStr = strtoupper($date->format('n/j, D')) . '.';
                $isPast = $appt->appointment_date < $today;
            @endphp
            <div class="schedule-item" style="{{ $isPast ? 'background:#c8c8c8; color:#888; opacity:0.7;' : '' }}">
                {{ $dayStr }} : {{ strtoupper($appt->full_name) }} W/ {{ strtoupper($appt->doctor) }}<br>
                TIME: {{ strtoupper($appt->appointment_time) }} @ {{ strtoupper($appt->medical_department) }} DEPT.
            </div>
        @empty
            <p style="font-size:0.8rem; color:#999; text-align:center; padding:20px 0;">No appointments yet.</p>
        @endforelse
    </div>
 
    {{-- PATIENT APPOINTMENT FORM --}}
    <div class="card">
        <div class="card-title">Patient Appointment</div>
 
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif
 
        <form method="POST" action="{{ route('appointment.store') }}">
            @csrf
 
            <div class="form-group">
                <label class="form-label">Full Name <em style="font-size:0.65rem;font-weight:400;">(Last Name, First Name M.I.)</em></label>
                <input class="form-input" type="text" name="full_name" value="{{ old('full_name') }}" required>
            </div>
 
            <div class="form-row form-row-3" style="margin-bottom:16px;">
                <div>
                    <label class="form-label">Age</label>
                    <div class="form-select-wrap">
                        <select class="form-select" name="age">
                            <option value=""></option>
                            @for($i = 1; $i <= 120; $i++)
                                <option value="{{ $i }}" {{ old('age') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div>
                    <label class="form-label">Birth Date</label>
                    <input class="form-input" type="date" name="birth_date" value="{{ old('birth_date') }}">
                </div>
                <div>
                    <label class="form-label">Religion</label>
                    <div class="form-select-wrap">
                        <select class="form-select" name="religion">
                            <option value=""></option>
                            <option value="Roman Catholic">Roman Catholic</option>
                            <option value="Islam">Islam</option>
                            <option value="Iglesia ni Cristo">Iglesia ni Cristo</option>
                            <option value="Protestant">Protestant</option>
                            <option value="Buddhism">Buddhism</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                </div>
            </div>
 
            <div class="form-group">
                <label class="form-label">Complete Address</label>
                <input class="form-input" type="text" name="complete_address" value="{{ old('complete_address') }}">
            </div>
 
            <div class="form-row form-row-2" style="margin-bottom:16px;">
                <div>
                    <label class="form-label">Phone No.</label>
                    <input class="form-input" type="text" name="phone_no" value="{{ old('phone_no') }}">
                </div>
                <div>
                    <label class="form-label">Email Acc.</label>
                    <input class="form-input" type="email" name="email_acc" value="{{ old('email_acc') }}">
                </div>
            </div>
 
            <div class="form-row form-row-2" style="margin-bottom:16px;">
                <div>
                    <label class="form-label">Appointment Date</label>
                    <input class="form-input" type="date" name="appointment_date" value="{{ old('appointment_date') }}" required>
                </div>
                <div>
                    <label class="form-label">Appointment Time</label>
                    <div class="form-select-wrap">
                        <select class="form-select" name="appointment_time" required>
                            <option value=""></option>
                            @foreach(['7:00AM','7:30AM','8:00AM','8:30AM','9:00AM','9:30AM','10:00AM','10:30AM','11:00AM','11:30AM','12:00PM','1:00PM','1:30PM','2:00PM','2:30PM','3:00PM','3:30PM','4:00PM','4:30PM','5:00PM'] as $t)
                                <option value="{{ $t }}" {{ old('appointment_time') == $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
 
            <div class="form-row form-row-2" style="margin-bottom:24px;">
                <div>
                    <label class="form-label">Medical Department</label>
                    <div class="form-select-wrap">
                        <select class="form-select" name="medical_department" required>
                            <option value=""></option>
                            <option value="Neurology">Neurology</option>
                            <option value="Orthopedics">Orthopedics</option>
                            <option value="Dermatology">Dermatology</option>
                            <option value="Cardiology">Cardiology</option>
                            <option value="Ophthalmology">Ophthalmology</option>
                            <option value="Emergency">Emergency</option>
                            <option value="ICU">ICU</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="form-label">Doctor</label>
                    <div class="form-select-wrap">
                        <select class="form-select" name="doctor" required>
                            <option value=""></option>
                            <option value="Dr. Bonilla">Dr. Bonilla</option>
                            <option value="Dr. Cabangbang">Dr. Cabangbang</option>
                            <option value="Dr. Lacson">Dr. Lacson</option>
                            <option value="Dr. Bello">Dr. Bello</option>
                            <option value="Dr. Pausanos">Dr. Pausanos</option>
                        </select>
                    </div>
                </div>
            </div>
 
            <div style="text-align:right;">
                <button class="btn-primary" type="submit">+New Appointment</button>
            </div>
        </form>
    </div>
</div>
@endsection
