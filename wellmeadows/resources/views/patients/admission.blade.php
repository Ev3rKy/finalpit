@extends('layouts.app')

@section('content')

<div class="topbar">
    <h2>Admission & Discharge</h2>
    <div class="topbar-actions">
        <span class="topbar-date">{{ now()->format('d M Y') }}</span>
        <a href="{{ route('patients.index') }}" class="btn btn-outline" style="font-size:12px;">All Records</a>
        <button onclick="openModal('admissionModal')" class="btn btn-teal">+ New Admission</button>
    </div>
</div>

<div class="content">

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    {{-- Stats Cards --}}
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:28px;">
        <div style="background:#1a1f5e; color:white; padding:20px; border-radius:12px;">
            <div style="font-size:10px; letter-spacing:1px; opacity:0.7; text-transform:uppercase;">Admissions Today</div>
            <div style="font-size:40px; font-weight:800; line-height:1.1;">{{ $inPatients }}</div>
            <div style="font-size:11px; opacity:0.5;">New In-patients</div>
        </div>
        <div style="background:#2dd4c0; color:white; padding:20px; border-radius:12px;">
            <div style="font-size:10px; letter-spacing:1px; opacity:0.7; text-transform:uppercase;">Discharges Today</div>
            <div style="font-size:40px; font-weight:800; line-height:1.1;">{{ $dischargedToday }}</div>
            <div style="font-size:11px; opacity:0.7;">Left Ward Today</div>
        </div>
        <div style="background:white; color:#1a1f5e; padding:20px; border-radius:12px; border:2px solid #e8e8e8;">
            <div style="font-size:10px; letter-spacing:1px; opacity:0.6; text-transform:uppercase;">Avg Length of Stay</div>
            <div style="font-size:40px; font-weight:800; line-height:1.1;">{{ round($avgStay ?? 0) }}<span style="font-size:18px;">d</span></div>
            <div style="font-size:11px; opacity:0.5;">Across all Wards</div>
        </div>
        <div style="background:white; color:#1a1f5e; padding:20px; border-radius:12px; border:2px solid #2dd4c0;">
            <div style="font-size:10px; letter-spacing:1px; opacity:0.6; text-transform:uppercase;">Out-patient Appts</div>
            <div style="font-size:40px; font-weight:800; line-height:1.1;">{{ $outPatients }}</div>
            <div style="font-size:11px; opacity:0.5;">Today's Clinic</div>
        </div>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">

        {{-- In-patient Admissions --}}
        <div style="background:white; border-radius:12px; padding:24px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                <h3 style="color:#1a1f5e; font-size:15px; font-weight:700;">In-patient Admissions</h3>
                <span style="background:#e8f4ff; color:#1a1f5e; padding:4px 10px; border-radius:6px; font-size:11px; font-weight:600;">{{ $inPatients }} Active</span>
            </div>
            <table style="width:100%; border-collapse:collapse; font-size:12px;">
                <thead>
                    <tr style="border-bottom:2px solid #f0f0f0; color:#aaa; text-transform:uppercase; font-size:10px; letter-spacing:1px;">
                        <th style="padding:8px 10px; text-align:left;">Patient</th>
                        <th style="padding:8px 10px; text-align:left;">Ward/Bed</th>
                        <th style="padding:8px 10px; text-align:left;">Admitted</th>
                        <th style="padding:8px 10px; text-align:left;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admissions->where('type', 'IN-PATIENT')->whereNull('date_actually_left') as $admission)
                    <tr style="border-bottom:1px solid #f8f8f8;">
                        <td style="padding:10px;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <div style="width:30px; height:30px; border-radius:50%; background:#1a1f5e; color:white; display:flex; align-items:center; justify-content:center; font-size:10px; font-weight:700; flex-shrink:0;">
                                    {{ strtoupper(substr($admission->patient->first_name,0,1).substr($admission->patient->last_name,0,1)) }}
                                </div>
                                <div>
                                    <div style="font-weight:600; font-size:12px;">{{ $admission->patient->first_name }} {{ $admission->patient->last_name }}</div>
                                    <div style="color:#aaa; font-size:10px;">{{ $admission->patient_no }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding:10px; color:#888; font-size:11px;">{{ $admission->ward_required ?? '—' }} · Bed {{ $admission->bed_number ?? '—' }}</td>
                        <td style="padding:10px; color:#888; font-size:11px;">{{ $admission->date_placed_ward ? \Carbon\Carbon::parse($admission->date_placed_ward)->format('d-M-y') : '—' }}</td>
                        <td style="padding:10px;">
                            <button onclick="openDischargeModal({{ $admission->id }}, '{{ $admission->patient->first_name }} {{ $admission->patient->last_name }}', '{{ $admission->patient_no }}', '{{ $admission->ward_required }}', '{{ $admission->bed_number }}', '{{ $admission->date_placed_ward }}', '{{ $admission->expected_stay }}')"
                                style="background:#e03131; color:white; padding:4px 10px; border-radius:6px; font-size:10px; font-weight:600; border:none; cursor:pointer;">
                                Discharge
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="padding:24px; text-align:center; color:#ccc; font-size:12px;">No active admissions.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Discharge Tracking --}}
        <div style="background:white; border-radius:12px; padding:24px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                <h3 style="color:#1a1f5e; font-size:15px; font-weight:700;">Discharge Tracking</h3>
                <span style="background:#fff3cd; color:#e67700; padding:4px 10px; border-radius:6px; font-size:11px; font-weight:600;">{{ $waitingList }} Due This Week</span>
            </div>
            <table style="width:100%; border-collapse:collapse; font-size:12px;">
                <thead>
                    <tr style="border-bottom:2px solid #f0f0f0; color:#aaa; text-transform:uppercase; font-size:10px; letter-spacing:1px;">
                        <th style="padding:8px 10px; text-align:left;">Patient</th>
                        <th style="padding:8px 10px; text-align:left;">Ward/Bed</th>
                        <th style="padding:8px 10px; text-align:left;">Exp. Leave</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admissions->whereNotNull('date_expected_leave')->whereNull('date_actually_left') as $admission)
                    <tr style="border-bottom:1px solid #f8f8f8;">
                        <td style="padding:10px;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <div style="width:30px; height:30px; border-radius:50%; background:#2dd4c0; color:white; display:flex; align-items:center; justify-content:center; font-size:10px; font-weight:700; flex-shrink:0;">
                                    {{ strtoupper(substr($admission->patient->first_name,0,1).substr($admission->patient->last_name,0,1)) }}
                                </div>
                                <div>
                                    <div style="font-weight:600; font-size:12px;">{{ $admission->patient->first_name }} {{ $admission->patient->last_name }}</div>
                                    <div style="color:#aaa; font-size:10px;">{{ $admission->patient_no }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding:10px; color:#888; font-size:11px;">{{ $admission->ward_required ?? '—' }} · Bed {{ $admission->bed_number ?? '—' }}</td>
                        <td style="padding:10px;">
                            <span style="background:#fff3cd; color:#e67700; padding:3px 8px; border-radius:20px; font-size:10px; font-weight:700;">
                                {{ $admission->date_expected_leave ? \Carbon\Carbon::parse($admission->date_expected_leave)->format('d-M-y') : '—' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="padding:24px; text-align:center; color:#ccc; font-size:12px;">No pending discharges.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- New Admission Modal --}}
<div class="modal-overlay" id="admissionModal">
    <div class="modal" style="width:650px;">
        <div class="modal-header">
            <h3>New Admission Form <span style="background:#1a1f5e; color:white; padding:3px 10px; border-radius:20px; font-size:11px; margin-left:8px;">IN-PATIENT</span></h3>
            <button class="modal-close" onclick="closeModal('admissionModal')">✕</button>
        </div>

        <form method="POST" action="{{ route('admission.store') }}">
            @csrf
            <input type="hidden" name="type" value="IN-PATIENT">
            <div class="form-grid">

                <div class="form-section-title" style="margin-top:0;">Patient Information</div>

                <div class="form-group">
                    <label>Patient Number *</label>
                    <select name="patient_id" id="admissionPatientSelect" required onchange="fillAdmissionDetails(this)"
                        style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%; background:white;">
                        <option value="">e.g. P10234</option>
                        @foreach($patients as $p)
                            <option value="{{ $p->id }}"
                                data-name="{{ $p->first_name }} {{ $p->last_name }}"
                                data-dob="{{ \Carbon\Carbon::parse($p->date_of_birth)->format('d-M-y') }}"
                                data-sex="{{ $p->sex }}"
                                data-marital="{{ $p->marital_status }}"
                                data-tel="{{ $p->tel_no }}">
                                {{ $p->patient_no }} — {{ $p->first_name }} {{ $p->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Patient Name</label>
                    <input type="text" id="admissionName" placeholder="Auto-filled"
                        style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%; background:#f9f9f9; color:#888;" readonly>
                </div>
                <div class="form-group">
                    <label>DOB</label>
                    <input type="text" id="admissionDob" placeholder="Auto-filled"
                        style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%; background:#f9f9f9; color:#888;" readonly>
                </div>
                <div class="form-group">
                    <label>Sex</label>
                    <input type="text" id="admissionSex" placeholder="Auto-filled"
                        style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%; background:#f9f9f9; color:#888;" readonly>
                </div>
                <div class="form-group">
                    <label>Marital Status</label>
                    <input type="text" id="admissionMarital" placeholder="Auto-filled"
                        style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%; background:#f9f9f9; color:#888;" readonly>
                </div>
                <div class="form-group">
                    <label>Tel. No.</label>
                    <input type="text" id="admissionTel" placeholder="Auto-filled"
                        style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%; background:#f9f9f9; color:#888;" readonly>
                </div>

                <div class="form-section-title">Ward & Bed</div>

                <div class="form-group">
                    <label>Ward Required *</label>
                    <input type="text" name="ward_required" placeholder="Select ward..."
                        style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%;">
                </div>
                <div class="form-group">
                    <label>Bed Number</label>
                    <input type="text" name="bed_number" placeholder="Select vacant bed..."
                        style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%;">
                </div>

                <div class="form-section-title">Dates</div>

                <div class="form-group">
                    <label>Date Placed on Waiting List</label>
                    <input type="date" name="date_placed_waiting"
                        style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%;">
                </div>
                <div class="form-group">
                    <label>Expected Stay (Days)</label>
                    <input type="number" name="expected_stay" placeholder="e.g. 5"
                        style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%;">
                </div>
                <div class="form-group">
                    <label>Date Placed in Ward *</label>
                    <input type="date" name="date_placed_ward" value="{{ date('Y-m-d') }}"
                        style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%;">
                </div>
                <div class="form-group">
                    <label>Date Expected to Leave</label>
                    <input type="date" name="date_expected_leave"
                        style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%;">
                </div>

            </div>

            <div class="form-actions">
                <button type="button" onclick="closeModal('admissionModal')" class="btn btn-outline" style="color:#666; border-color:#ddd;">Cancel</button>
                <button type="reset" class="btn btn-outline" style="color:#666; border-color:#ddd;">Clear</button>
                <button type="submit" class="btn btn-blue">Confirm Admission</button>
            </div>
        </form>
    </div>
</div>

{{-- Discharge Modal --}}
<div class="modal-overlay" id="dischargeModal">
    <div class="modal" style="width:600px;">
        <div class="modal-header">
            <h3>Discharge Patient</h3>
            <button class="modal-close" onclick="closeModal('dischargeModal')">✕</button>
        </div>

        <form method="POST" id="dischargeForm">
            @csrf
            @method('PATCH')

            {{-- Patient Summary Card --}}
            <div style="background:#f5f0e8; border-radius:10px; padding:16px; margin-bottom:20px; display:flex; gap:12px; align-items:center;">
                <div id="dischargeAvatar" style="width:40px; height:40px; border-radius:50%; background:#2dd4c0; color:white; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:700; flex-shrink:0;"></div>
                <div>
                    <div id="dischargeName" style="font-weight:700; color:#1a1f5e; font-size:14px;"></div>
                    <div id="dischargeInfo" style="color:#888; font-size:12px; margin-top:2px;"></div>
                </div>
                <div id="dischargeDueTag" style="margin-left:auto; background:#fff3cd; color:#e67700; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:700;"></div>
            </div>

            <div class="form-grid">
                <div class="form-section-title" style="margin-top:0;">Discharge Details</div>

                <div class="form-group">
                    <label>Date Actually Left Ward *</label>
                    <input type="date" name="date_actually_left" value="{{ date('Y-m-d') }}"
                        style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%;">
                </div>
                <div class="form-group">
                    <label>Discharge Type</label>
                    <select name="discharge_type"
                        style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%; background:white;">
                        <option value="">Select</option>
                        <option value="Home">Home</option>
                        <option value="Transfer">Transfer</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group full">
                    <label>Discharge Notes</label>
                    <textarea name="discharge_notes" placeholder="Condition on discharge, follow-up instructions..."
                        style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%; height:80px; resize:none;"></textarea>
                </div>
                <div class="form-group">
                    <label>Follow-up Appointment</label>
                    <input type="text" name="followup_appointment" placeholder="dd-mmm-yy · Time"
                        style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%;">
                </div>
                <div class="form-group">
                    <label>Medications on Discharge</label>
                    <input type="text" name="medications_on_discharge" placeholder="Drug name, dosage..."
                        style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%;">
                </div>

                <div class="form-section-title">Out-patient Clinic (if required)</div>

                <div class="form-group">
                    <label>Appointment Number</label>
                    <input type="text" name="appointment_number" placeholder="Auto-generated"
                        style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%; background:#f9f9f9;">
                </div>
                <div class="form-group">
                    <label>Clinic Date & Time</label>
                    <input type="text" name="clinic_date_time" placeholder="dd-mmm-yy · hh:mm"
                        style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%;">
                </div>
                <div class="form-group">
                    <label>Consultant</label>
                    <input type="text" name="consultant" placeholder="Select consultant..."
                        style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%;">
                </div>
                <div class="form-group">
                    <label>Examination Room</label>
                    <input type="text" name="examination_room" placeholder="e.g. Room E252"
                        style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%;">
                </div>
            </div>

            <div class="form-actions">
                <button type="button" onclick="closeModal('dischargeModal')" class="btn btn-outline" style="color:#666; border-color:#ddd;">Cancel</button>
                <button type="submit" class="btn btn-red">Confirm Discharge</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
function openModal(id) {
    document.getElementById(id).classList.add('active');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).classList.remove('active');
    document.body.style.overflow = '';
}
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', function(e) {
        if (e.target === this) closeModal(this.id);
    });
});
function fillAdmissionDetails(select) {
    const opt = select.options[select.selectedIndex];
    document.getElementById('admissionName').value = opt.dataset.name || '';
    document.getElementById('admissionDob').value = opt.dataset.dob || '';
    document.getElementById('admissionSex').value = opt.dataset.sex || '';
    document.getElementById('admissionMarital').value = opt.dataset.marital || '';
    document.getElementById('admissionTel').value = opt.dataset.tel || '';
}
function openDischargeModal(id, name, patientNo, ward, bed, admitted, expectedStay) {
    const initials = name.split(' ').map(n => n[0]).join('').toUpperCase();
    document.getElementById('dischargeAvatar').innerText = initials;
    document.getElementById('dischargeName').innerText = name;
    document.getElementById('dischargeInfo').innerText = patientNo + ' · ' + ward + ' · Bed ' + bed + ' · Admitted ' + admitted;
    document.getElementById('dischargeDueTag').innerText = 'Expected Stay: ' + expectedStay + ' days';
    document.getElementById('dischargeForm').action = '/admission-discharge/' + id + '/discharge';
    openModal('dischargeModal');
}
</script>
@endsection