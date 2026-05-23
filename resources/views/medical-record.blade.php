@extends('layouts.app')
 
@section('content')
<div class="card" style="max-width:1100px; margin:0 auto;">
    <div class="card-title">Medical Record</div>
 
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert-error">{{ $errors->first() }}</div>
    @endif
 
    <form method="POST" action="{{ route('medical-record.store') }}">
        @csrf
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:36px;">
 
            {{-- LEFT COLUMN --}}
            <div>
                <div class="form-group">
                    <label class="form-label">Patient's Full Name <em style="font-size:0.65rem;font-weight:400;">(Last Name, First Name M.I.)</em></label>
                    <input class="form-input" type="text" name="patient_full_name" value="{{ old('patient_full_name') }}" required>
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
                        <label class="form-label">Treatment Date &amp; Time</label>
                        <input class="form-input" type="datetime-local" name="treatment_datetime" value="{{ old('treatment_datetime') }}" required>
                    </div>
                </div>
 
                <div class="form-row form-row-2" style="margin-bottom:16px;">
                    <div>
                        <label class="form-label">Doctor</label>
                        <input class="form-input" type="text" name="doctor" value="{{ old('doctor') }}" required placeholder="e.g. Dr. Cabangbang">
                    </div>
                    <div>
                        <label class="form-label">Procedure</label>
                        <div class="form-select-wrap">
                            <select class="form-select" name="procedure" required>
                                <option value=""></option>
                                <option value="Check-Up">Check-Up</option>
                                <option value="Surgery">Surgery</option>
                                <option value="Laboratory">Laboratory</option>
                                <option value="X-Ray">X-Ray</option>
                                <option value="Consultation">Consultation</option>
                                <option value="Emergency">Emergency</option>
                                <option value="Physical Therapy">Physical Therapy</option>
                            </select>
                        </div>
                    </div>
                </div>
 
                <div class="form-group">
                    <label class="form-label" style="margin-bottom:10px;">Vital Check</label>
                    <div class="form-row form-row-3">
                        <div>
                            <label class="form-label">BP</label>
                            <input class="form-input" type="text" name="bp" value="{{ old('bp') }}" placeholder="120/80">
                        </div>
                        <div>
                            <label class="form-label">Temperature</label>
                            <input class="form-input" type="text" name="temperature" value="{{ old('temperature') }}" placeholder="36.1">
                        </div>
                        <div>
                            <label class="form-label">SpO2</label>
                            <input class="form-input" type="text" name="spo2" value="{{ old('spo2') }}" placeholder="95">
                        </div>
                    </div>
                </div>
            </div>
 
            {{-- RIGHT COLUMN — Medical Notes --}}
            <div style="display:flex; flex-direction:column;">
                <label class="form-label" style="margin-bottom:8px;">Medical Notes</label>
                <div class="rte-toolbar">
                    <button type="button" class="rte-btn" onclick="fmt('bold')"><strong>B</strong></button>
                    <button type="button" class="rte-btn" onclick="fmt('italic')"><em>I</em></button>
                    <button type="button" class="rte-btn" onclick="fmt('underline')"><u>U</u></button>
                </div>
                <div class="rte-area" id="medical-notes-editor" contenteditable="true" style="flex:1;"></div>
                <input type="hidden" name="medical_notes" id="medical-notes-hidden">
            </div>
        </div>
 
        <div style="text-align:right; margin-top:28px;">
            <button class="btn-primary" type="submit" onclick="syncNotes()">Save</button>
        </div>
    </form>
</div>
@endsection
 
@push('scripts')
<script>
function fmt(cmd) { document.execCommand(cmd, false, null); }
function syncNotes() {
    document.getElementById('medical-notes-hidden').value =
        document.getElementById('medical-notes-editor').innerHTML;
}
</script>
@endpush
