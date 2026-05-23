@extends('layouts.app')

@section('content')

<div class="topbar">
    <h2>Register and Update Patient</h2>
    <div class="topbar-actions">
        <span class="topbar-date">{{ now()->format('d M Y') }}</span>
        <button onclick="openModal('registerModal')" class="btn btn-teal">+ New Patient</button>
    </div>
</div>

<div class="content">

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    {{-- Stats Cards --}}
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:28px;">
        <div style="background:#1a1f5e; color:white; padding:20px; border-radius:12px;">
            <div style="font-size:10px; letter-spacing:1px; opacity:0.7; text-transform:uppercase;">Total Patients</div>
            <div style="font-size:40px; font-weight:800; line-height:1.1;">{{ $totalPatients }}</div>
            <div style="font-size:11px; opacity:0.5;">Active Patients</div>
        </div>
        <div style="background:#2dd4c0; color:white; padding:20px; border-radius:12px;">
            <div style="font-size:10px; letter-spacing:1px; opacity:0.7; text-transform:uppercase;">Registered This Month</div>
            <div style="font-size:40px; font-weight:800; line-height:1.1;">{{ $registeredThisMonth }}</div>
            <div style="font-size:11px; opacity:0.7;">New Referrals</div>
        </div>
        <div style="background:white; color:#1a1f5e; padding:20px; border-radius:12px; border:2px solid #e8e8e8;">
            <div style="font-size:10px; letter-spacing:1px; opacity:0.6; text-transform:uppercase;">Out-Patients</div>
            <div style="font-size:40px; font-weight:800; line-height:1.1;">{{ $outPatients }}</div>
            <div style="font-size:11px; opacity:0.5;">Clinic Appointment</div>
        </div>
        <div style="background:white; color:#1a1f5e; padding:20px; border-radius:12px; border:2px solid #2dd4c0;">
            <div style="font-size:10px; letter-spacing:1px; opacity:0.6; text-transform:uppercase;">In-Patients</div>
            <div style="font-size:40px; font-weight:800; line-height:1.1;">{{ $inPatients }}</div>
            <div style="font-size:11px; opacity:0.5;">Currently Admitted</div>
        </div>
    </div>

    {{-- Patient Table --}}
    <div style="background:white; border-radius:12px; padding:24px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <h3 style="color:#1a1f5e; font-size:16px; font-weight:700;">Patient Register</h3>
            <input type="text" id="searchInput" placeholder="🔍  Search by name, patient no, or date..."
                style="padding:8px 14px; border:1px solid #eee; border-radius:8px; font-size:12px; width:300px; outline:none;"
                onkeyup="searchTable()">
        </div>

        <table style="width:100%; border-collapse:collapse; font-size:13px;">
            <thead>
                <tr style="border-bottom:2px solid #f0f0f0; color:#aaa; text-transform:uppercase; font-size:10px; letter-spacing:1px;">
                    <th style="padding:10px 12px; text-align:left;">Patient</th>
                    <th style="padding:10px 12px; text-align:left;">Patient No.</th>
                    <th style="padding:10px 12px; text-align:left;">DOB</th>
                    <th style="padding:10px 12px; text-align:left;">Marital Status</th>
                    <th style="padding:10px 12px; text-align:left;">Registered</th>
                    <th style="padding:10px 12px; text-align:left;">Status</th>
                    <th style="padding:10px 12px; text-align:left;">Actions</th>
                </tr>
            </thead>
            <tbody id="patientTable">
                @forelse($patients as $patient)
                <tr style="border-bottom:1px solid #f8f8f8;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='white'">
                    <td style="padding:12px;">
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:34px; height:34px; border-radius:50%; background:#1a1f5e; color:white; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; flex-shrink:0;">
                                {{ strtoupper(substr($patient->first_name,0,1).substr($patient->last_name,0,1)) }}
                            </div>
                            <span style="font-weight:500;">{{ $patient->first_name }} {{ $patient->last_name }}</span>
                        </div>
                    </td>
                    <td style="padding:12px; color:#888;">{{ $patient->patient_no }}</td>
                    <td style="padding:12px; color:#888;">{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('d-M-y') }}</td>
                    <td style="padding:12px; color:#888;">{{ $patient->marital_status ?? '—' }}</td>
                    <td style="padding:12px; color:#888;">{{ \Carbon\Carbon::parse($patient->date_registered)->format('d-M-y') }}</td>
                    <td style="padding:12px;">
                        <span style="padding:4px 12px; border-radius:20px; font-size:11px; font-weight:700;
                            background:{{ $patient->status == 'IN-PATIENT' ? '#d3f9d8' : '#fff3cd' }};
                            color:{{ $patient->status == 'IN-PATIENT' ? '#2b8a3e' : '#e67700' }};">
                            {{ $patient->status }}
                        </span>
                    </td>
                    <td style="padding:12px;">
                        <a href="{{ route('patients.edit', $patient->id) }}" style="color:#1a1f5e; font-size:12px; font-weight:600; margin-right:10px; text-decoration:none;">Edit →</a>
                        <a href="{{ route('patients.medical', $patient->id) }}" style="color:#2dd4c0; font-size:12px; font-weight:600; text-decoration:none;">Records →</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding:32px; text-align:center; color:#ccc; font-size:13px;">No patients registered yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
{{-- Register Patient Modal --}}
<div class="modal-overlay" id="registerModal">
    <div class="modal" style="width:750px;">
        <div class="modal-header">
            <h3>Patient Registration Form</h3>
            <button class="modal-close" onclick="closeModal('registerModal')">✕</button>
        </div>

        <form method="POST" action="{{ route('patients.store') }}">
            @csrf
            <div class="form-grid">

                <div class="form-section-title">Personal Information</div>

                <div class="form-group">
                    <label>First Name *</label>
                    <input type="text" name="first_name" required>
                </div>
                <div class="form-group">
                    <label>Last Name *</label>
                    <input type="text" name="last_name" required>
                </div>
                <div class="form-group full">
                    <label>Address *</label>
                    <input type="text" name="address" required>
                </div>
                <div class="form-group">
                    <label>Tel No.</label>
                    <input type="text" name="tel_no">
                </div>
                <div class="form-group">
                    <label>Sex *</label>
                    <select name="sex" required>
                        <option value="">Select</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Date of Birth *</label>
                    <input type="date" name="date_of_birth" required>
                </div>
                <div class="form-group">
                    <label>Marital Status</label>
                    <select name="marital_status">
                        <option value="">Select</option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Widowed">Widowed</option>
                        <option value="Divorced">Divorced</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Date Registered</label>
                    <input type="date" name="date_registered" value="{{ date('Y-m-d') }}">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="OUT-PATIENT">OUT-PATIENT</option>
                        <option value="IN-PATIENT">IN-PATIENT</option>
                    </select>
                </div>

                <div class="form-section-title">Next of Kin</div>

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="kin_full_name" style="background:#fff5f5;">
                </div>
                <div class="form-group">
                    <label>Relationship</label>
                    <input type="text" name="kin_relationship" style="background:#fff5f5;">
                </div>
                <div class="form-group full">
                    <label>Address</label>
                    <input type="text" name="kin_address">
                </div>
                <div class="form-group">
                    <label>Tel No.</label>
                    <input type="text" name="kin_tel_no">
                </div>

                <div class="form-section-title">Local Doctor Details</div>

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="doctor_full_name">
                </div>
                <div class="form-group">
                    <label>Clinic / Tel No.</label>
                    <input type="text" name="doctor_clinic_tel">
                </div>
                <div class="form-group full">
                    <label>Address</label>
                    <input type="text" name="doctor_address">
                </div>

            </div>

            <div class="form-actions">
                <button type="button" onclick="closeModal('registerModal')" class="btn btn-outline" style="color:#666; border-color:#ddd;">Cancel</button>
                <button type="reset" class="btn btn-outline" style="color:#666; border-color:#ddd;">Reset</button>
                <button type="submit" class="btn btn-blue">Save Patient</button>
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
// Close modal when clicking outside
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', function(e) {
        if (e.target === this) closeModal(this.id);
    });
});
function searchTable() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#patientTable tr');
    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(input) ? '' : 'none';
    });
}
</script>
@endsection