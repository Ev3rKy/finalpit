@extends('layouts.app')

@section('content')

<div class="topbar">
    <h2>Medical Records</h2>
    <div class="topbar-actions">
        <a href="{{ route('patients.index') }}" class="btn btn-outline" style="font-size:12px;">← Back to Patients</a>
        <button onclick="openModal('medicationModal')" class="btn btn-teal">+ Add Entry</button>
    </div>
</div>

<div class="content">

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    {{-- Patient Profile Card --}}
    <div style="background:#1a1f5e; border-radius:12px; padding:24px; margin-bottom:24px; display:flex; justify-content:space-between; align-items:center;">
        <div style="display:flex; align-items:center; gap:16px;">
            <div style="width:52px; height:52px; border-radius:50%; background:#2dd4c0; color:white; display:flex; align-items:center; justify-content:center; font-size:18px; font-weight:800;">
                {{ strtoupper(substr($patient->first_name,0,1).substr($patient->last_name,0,1)) }}
            </div>
            <div>
                <div style="color:white; font-size:20px; font-weight:700;">{{ $patient->first_name }} {{ $patient->last_name }}</div>
                <div style="color:rgba(255,255,255,0.5); font-size:12px; margin-top:2px;">
    Patient No. {{ $patient->patient_no }}
    @if($patient->medicalRecord)
        &nbsp;·&nbsp; Bed No. {{ $patient->medicalRecord->bed_number }}
        &nbsp;·&nbsp; Ward {{ $patient->medicalRecord->ward_number }}
        &nbsp;·&nbsp; {{ $patient->medicalRecord->ward_name }}
    @elseif($admission)
        &nbsp;·&nbsp; Bed No. {{ $admission->bed_number }}
        &nbsp;·&nbsp; Ward {{ $admission->ward_required }}
    @endif
                </div>
                <div style="display:flex; gap:16px; margin-top:8px;">
                    <span style="color:rgba(255,255,255,0.5); font-size:12px;">
                        <span style="color:rgba(255,255,255,0.3);">SEX</span>&nbsp;&nbsp;{{ $patient->sex }}
                    </span>
                    <span style="color:rgba(255,255,255,0.5); font-size:12px;">
                        <span style="color:rgba(255,255,255,0.3);">MARITAL STATUS</span>&nbsp;&nbsp;{{ $patient->marital_status ?? '—' }}
                    </span>
                    @if($patient->medicalRecord)
                    <span style="color:rgba(255,255,255,0.5); font-size:12px;">
                        <span style="color:rgba(255,255,255,0.3);">WARD/BED</span>&nbsp;&nbsp;{{ $patient->medicalRecord->ward_name }} · Bed {{ $patient->medicalRecord->bed_number }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
        <div style="text-align:right;">
            <div style="color:rgba(255,255,255,0.3); font-size:10px; text-transform:uppercase; letter-spacing:1px;">Date of Birth</div>
            <div style="color:white; font-size:14px; font-weight:600; margin-top:2px;">
                {{ \Carbon\Carbon::parse($patient->date_of_birth)->format('d M Y') }}
            </div>
            <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-outline btn-sm" style="margin-top:10px; display:inline-block;">Edit Profile</a>
        </div>
    </div>

    {{-- Medication Table --}}
    <div style="background:white; border-radius:12px; padding:24px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
            <h3 style="color:#1a1f5e; font-size:15px; font-weight:700;">Patient Medication Form</h3>
            <a href="#" style="color:#2dd4c0; font-size:12px; font-weight:600; text-decoration:none;">Full History →</a>
        </div>
        <div style="font-size:12px; color:#888; margin-bottom:16px;">
    <span style="color:#1a1f5e; font-weight:600;">Full Name:</span> {{ $patient->first_name }} {{ $patient->last_name }} &nbsp;
    <span style="color:#1a1f5e; font-weight:600;">Patient No:</span> {{ $patient->patient_no }} &nbsp;
    @if($patient->medicalRecord)
        <span style="color:#1a1f5e; font-weight:600;">Bed Number:</span> {{ $patient->medicalRecord->bed_number }} &nbsp;
        <span style="color:#1a1f5e; font-weight:600;">Ward Number:</span> {{ $patient->medicalRecord->ward_number }} &nbsp;
        <span style="color:#1a1f5e; font-weight:600;">Ward Name:</span> {{ $patient->medicalRecord->ward_name }}
    @elseif($admission)
        <span style="color:#1a1f5e; font-weight:600;">Bed Number:</span> {{ $admission->bed_number }} &nbsp;
        <span style="color:#1a1f5e; font-weight:600;">Ward:</span> {{ $admission->ward_required }}
    @endif
</div>

        <table style="width:100%; border-collapse:collapse; font-size:12px;">
            <thead>
                <tr style="border-bottom:2px solid #f0f0f0; color:#aaa; text-transform:uppercase; font-size:10px; letter-spacing:1px;">
                    <th style="padding:10px 12px; text-align:left;">Drug Number</th>
                    <th style="padding:10px 12px; text-align:left;">Name</th>
                    <th style="padding:10px 12px; text-align:left;">Description</th>
                    <th style="padding:10px 12px; text-align:left;">Dosage</th>
                    <th style="padding:10px 12px; text-align:left;">Method of Admin</th>
                    <th style="padding:10px 12px; text-align:left;">Units/Day</th>
                    <th style="padding:10px 12px; text-align:left;">Start Date</th>
                    <th style="padding:10px 12px; text-align:left;">Finish Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($medications as $med)
                <tr style="border-bottom:1px solid #f8f8f8;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='white'">
                    <td style="padding:10px 12px; color:#888;">{{ $med->drug_number }}</td>
                    <td style="padding:10px 12px; font-weight:500;">{{ $med->drug_name }}</td>
                    <td style="padding:10px 12px; color:#888;">{{ $med->description ?? '—' }}</td>
                    <td style="padding:10px 12px; color:#888;">{{ $med->dosage ?? '—' }}</td>
                    <td style="padding:10px 12px; color:#888;">{{ strtoupper($med->method_of_admin ?? '—') }}</td>
                    <td style="padding:10px 12px; color:#888;">{{ $med->units_per_day ?? '—' }}</td>
                    <td style="padding:10px 12px; color:#888;">{{ \Carbon\Carbon::parse($med->start_date)->format('d-M-y') }}</td>
                    <td style="padding:10px 12px; color:#888;">{{ $med->finish_date ? \Carbon\Carbon::parse($med->finish_date)->format('d-M-y') : '—' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="padding:32px; text-align:center; color:#ccc; font-size:13px;">No medication records yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
{{-- Add Medication Modal --}}
<div class="modal-overlay" id="medicationModal">
    <div class="modal" style="width:650px;">
        <div class="modal-header">
            <h3>Prescribe / Record Medication</h3>
            <button class="modal-close" onclick="closeModal('medicationModal')">✕</button>
        </div>

        <form method="POST" action="{{ route('medications.store') }}">
            @csrf
            <input type="hidden" name="patient_id" value="{{ $patient->id }}">
            <div class="form-grid">

                <div class="form-group">
                    <label>Drug Number *</label>
                    <input type="text" name="drug_number" required style="background:#fff5f5;">
                </div>
                <div class="form-group">
                    <label>Drug Name *</label>
                    <input type="text" name="drug_name" required>
                </div>
                <div class="form-group full">
                    <label>Description</label>
                    <input type="text" name="description">
                </div>
                <div class="form-group">
                    <label>Dosage</label>
                    <input type="text" name="dosage">
                </div>
                <div class="form-group">
                    <label>Method of Admin</label>
                    <select name="method_of_admin">
                        <option value="">Select</option>
                        <option value="ORAL">ORAL</option>
                        <option value="IV">IV</option>
                        <option value="IM">IM</option>
                        <option value="SC">SC</option>
                        <option value="TOPICAL">TOPICAL</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Units Per Day</label>
                    <input type="number" name="units_per_day" min="1">
                </div>
                <div class="form-group">
                    <label>Patient</label>
                    <input type="text" value="{{ $patient->first_name }} {{ $patient->last_name }}" disabled style="color:#888;">
                </div>
                <div class="form-group">
                    <label>Start Date *</label>
                    <input type="date" name="start_date" required value="{{ date('Y-m-d') }}" style="background:#fff5f5;">
                </div>
                <div class="form-group">
                    <label>Finish Date</label>
                    <input type="date" name="finish_date">
                </div>

            </div>

            <div class="form-actions">
                <button type="button" onclick="closeModal('medicationModal')" class="btn btn-outline" style="color:#666; border-color:#ddd;">Cancel</button>
                <button type="reset" class="btn btn-outline" style="color:#666; border-color:#ddd;">Reset</button>
                <button type="submit" class="btn btn-blue">Save Entry</button>
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
</script>
@endsection