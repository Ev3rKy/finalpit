@extends('layouts.app')

@section('content')

<div class="topbar">
    <h2>Ward & Bed Assignment</h2>
    <div class="topbar-actions">
        <span class="topbar-date">{{ now()->format('d M Y') }}</span>
        <button onclick="openModal('assignModal')" class="btn btn-teal">+ Assign Bed</button>
    </div>
</div>

<div class="content">

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:28px;">
        <div style="background:#1a1f5e; color:white; padding:20px; border-radius:12px;">
            <div style="font-size:10px; letter-spacing:1px; opacity:0.7; text-transform:uppercase;">Total Beds</div>
            <div style="font-size:40px; font-weight:800; line-height:1.1;">{{ $totalBeds }}</div>
            <div style="font-size:11px; opacity:0.5;">77 Wards</div>
        </div>
        <div style="background:#2dd4c0; color:white; padding:20px; border-radius:12px;">
            <div style="font-size:10px; letter-spacing:1px; opacity:0.7; text-transform:uppercase;">Occupied</div>
            <div style="font-size:40px; font-weight:800; line-height:1.1;">{{ $occupied }}</div>
            <div style="font-size:11px; opacity:0.7;">{{ $totalBeds > 0 ? round(($occupied/$totalBeds)*100) : 0 }}% Occupancy</div>
        </div>
        <div style="background:white; color:#1a1f5e; padding:20px; border-radius:12px; border:2px solid #e8e8e8;">
            <div style="font-size:10px; letter-spacing:1px; opacity:0.6; text-transform:uppercase;">Vacant</div>
            <div style="font-size:40px; font-weight:800; line-height:1.1;">{{ $vacant }}</div>
            <div style="font-size:11px; opacity:0.5;">Available Now</div>
        </div>
        <div style="background:white; color:#1a1f5e; padding:20px; border-radius:12px; border:2px solid #2dd4c0;">
            <div style="font-size:10px; letter-spacing:1px; opacity:0.6; text-transform:uppercase;">Waiting List</div>
            <div style="font-size:40px; font-weight:800; line-height:1.1;">{{ $waitingList }}</div>
            <div style="font-size:11px; opacity:0.5;">Across all Wards</div>
        </div>
    </div>

    <div style="background:white; border-radius:12px; padding:24px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <h3 style="color:#1a1f5e; font-size:15px; font-weight:700;">Patient Allocation Report</h3>
            <input type="text" id="searchInput" placeholder="🔍  Search patient..."
                style="padding:8px 14px; border:1px solid #eee; border-radius:8px; font-size:12px; width:260px; outline:none;"
                onkeyup="searchTable()">
        </div>

        <table style="width:100%; border-collapse:collapse; font-size:13px;">
            <thead>
                <tr style="border-bottom:2px solid #f0f0f0; color:#aaa; text-transform:uppercase; font-size:10px; letter-spacing:1px;">
                    <th style="padding:10px 12px; text-align:left;">Patient</th>
                    <th style="padding:10px 12px; text-align:left;">Patient No.</th>
                    <th style="padding:10px 12px; text-align:left;">Ward</th>
                    <th style="padding:10px 12px; text-align:left;">Bed</th>
                    <th style="padding:10px 12px; text-align:left;">Date Placed</th>
                    <th style="padding:10px 12px; text-align:left;">Expected Stay</th>
                    <th style="padding:10px 12px; text-align:left;">Expected Leave</th>
                    <th style="padding:10px 12px; text-align:left;">Date Left</th>
                    <th style="padding:10px 12px; text-align:left;">Action</th>
                </tr>
            </thead>
            <tbody id="patientTable">
                @forelse($patients as $patient)
                @if($patient->medicalRecord)
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
                    <td style="padding:12px; color:#888;">{{ $patient->medicalRecord->ward_name ?? '—' }}</td>
                    <td style="padding:12px;">
                        <span style="background:#2dd4c0; color:white; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700;">
                            BED {{ $patient->medicalRecord->bed_number ?? '—' }}
                        </span>
                    </td>
                    <td style="padding:12px; color:#888;">{{ $patient->medicalRecord->date_placed ? \Carbon\Carbon::parse($patient->medicalRecord->date_placed)->format('d-M-y') : '—' }}</td>
                    <td style="padding:12px; color:#888;">{{ $patient->medicalRecord->expected_stay ?? '—' }} days</td>
                    <td style="padding:12px; color:#888;">{{ $patient->medicalRecord->date_expected_leave ? \Carbon\Carbon::parse($patient->medicalRecord->date_expected_leave)->format('d-M-y') : '—' }}</td>
                    <td style="padding:12px; color:#888;">{{ $patient->medicalRecord->date_actually_left ? \Carbon\Carbon::parse($patient->medicalRecord->date_actually_left)->format('d-M-y') : '—' }}</td>
                    <td style="padding:12px;">
                        <button onclick="openEditModal({{ $patient->id }}, '{{ $patient->medicalRecord->ward_number }}', '{{ $patient->medicalRecord->ward_name }}', '{{ $patient->medicalRecord->bed_number }}', '{{ $patient->medicalRecord->date_placed }}', '{{ $patient->medicalRecord->expected_stay }}', '{{ $patient->medicalRecord->date_expected_leave }}', '{{ $patient->medicalRecord->date_actually_left }}')"
                            style="background:#2dd4c0; color:white; padding:5px 12px; border-radius:6px; font-size:11px; font-weight:600; border:none; cursor:pointer;">
                            Edit
                        </button>
                    </td>
                </tr>
                @endif
                @empty
                <tr>
                    <td colspan="9" style="padding:32px; text-align:center; color:#ccc; font-size:13px;">No ward assignments yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
{{-- Assign Bed Modal --}}
<div class="modal-overlay" id="assignModal">
    <div class="modal" style="width:750px;">
        <div class="modal-header">
            <h3>Assign Patient to Ward / Bed</h3>
            <button class="modal-close" onclick="closeModal('assignModal')">✕</button>
        </div>

        <form method="POST" action="{{ route('ward.store') }}">
            @csrf
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:32px;">

                <div>
                    <div class="form-section-title" style="margin-top:0;">Patient</div>
                    <div class="form-group" style="margin-bottom:16px;">
                        <label>Patient Number *</label>
                        <select name="patient_id" id="patientSelect" required onchange="fillPatientName(this)"
                            style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%; background:white;">
                            <option value="">Select Patient</option>
                            @foreach($patients as $p)
                                <option value="{{ $p->id }}" data-name="{{ $p->first_name }} {{ $p->last_name }}">
                                    {{ $p->patient_no }} — {{ $p->first_name }} {{ $p->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom:16px;">
                        <label>Patient Name *</label>
                        <input type="text" id="patientName" placeholder="Auto-filled from number"
                            style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%; background:#f9f9f9; color:#888;" readonly>
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:16px;">
                        <div class="form-group">
                            <label>Ward Number</label>
                            <input type="text" name="ward_number"
                                style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%;">
                        </div>
                        <div class="form-group">
                            <label>Ward Name</label>
                            <input type="text" name="ward_name"
                                style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bed Name</label>
                        <input type="text" name="bed_number"
                            style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%;">
                    </div>
                </div>

                <div>
                    <div class="form-section-title" style="margin-top:0;">Ward List & Stay Details</div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:16px;">
                        <div class="form-group">
                            <label>Date Placed</label>
                            <input type="date" name="date_placed" value="{{ date('Y-m-d') }}"
                                style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%;">
                        </div>
                        <div class="form-group">
                            <label>Expected Duration (days)</label>
                            <input type="number" name="expected_stay" min="1"
                                style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%;">
                        </div>
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:16px;">
                        <div class="form-group">
                            <label>Date Placed in Ward</label>
                            <input type="date" name="date_placed_in_ward"
                                style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%;">
                        </div>
                        <div class="form-group">
                            <label>Date Expected to Leave</label>
                            <input type="date" name="date_expected_leave"
                                style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Date Actually Left Ward</label>
                        <input type="date" name="date_actually_left"
                            style="border:1px solid #eee; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; width:100%;">
                    </div>
                </div>

            </div>

            <div class="form-actions">
                <button type="button" onclick="closeModal('assignModal')" class="btn btn-outline" style="color:#666; border-color:#ddd;">Cancel</button>
                <button type="reset" class="btn btn-outline" style="color:#666; border-color:#ddd;">Clear</button>
                <button type="submit" class="btn btn-blue">Confirm Allocation</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Assignment Modal --}}
<div class="modal-overlay" id="editModal">
    <div class="modal" style="width:500px;">
        <div class="modal-header">
            <h3>Edit Ward Assignment</h3>
            <button class="modal-close" onclick="closeModal('editModal')">✕</button>
        </div>
        <form method="POST" action="{{ route('ward.store') }}">
            @csrf
            <input type="hidden" name="patient_id" id="editPatientId">
            <div class="form-grid">
                <div class="form-group">
                    <label>Ward Number</label>
                    <input type="text" name="ward_number" id="editWardNumber">
                </div>
                <div class="form-group">
                    <label>Ward Name</label>
                    <input type="text" name="ward_name" id="editWardName">
                </div>
                <div class="form-group">
                    <label>Bed Number</label>
                    <input type="text" name="bed_number" id="editBedNumber">
                </div>
                <div class="form-group">
                    <label>Date Placed</label>
                    <input type="date" name="date_placed" id="editDatePlaced">
                </div>
                <div class="form-group">
                    <label>Expected Stay (days)</label>
                    <input type="number" name="expected_stay" id="editExpectedStay">
                </div>
                <div class="form-group">
                    <label>Date Expected Leave</label>
                    <input type="date" name="date_expected_leave" id="editDateExpectedLeave">
                </div>
                <div class="form-group full">
                    <label>Date Actually Left</label>
                    <input type="date" name="date_actually_left" id="editDateActuallyLeft">
                </div>
            </div>
            <div class="form-actions">
                <button type="button" onclick="closeModal('editModal')" class="btn btn-outline" style="color:#666; border-color:#ddd;">Cancel</button>
                <button type="submit" class="btn btn-blue">Save Changes</button>
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
function fillPatientName(select) {
    const selected = select.options[select.selectedIndex];
    document.getElementById('patientName').value = selected.dataset.name || '';
}
function openEditModal(patientId, wardNumber, wardName, bedNumber, datePlaced, expectedStay, dateExpectedLeave, dateActuallyLeft) {
    document.getElementById('editPatientId').value = patientId;
    document.getElementById('editWardNumber').value = wardNumber;
    document.getElementById('editWardName').value = wardName;
    document.getElementById('editBedNumber').value = bedNumber;
    document.getElementById('editDatePlaced').value = datePlaced;
    document.getElementById('editExpectedStay').value = expectedStay;
    document.getElementById('editDateExpectedLeave').value = dateExpectedLeave;
    document.getElementById('editDateActuallyLeft').value = dateActuallyLeft;
    openModal('editModal');
}
function searchTable() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#patientTable tr');
    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(input) ? '' : 'none';
    });
}
</script>
@endsection