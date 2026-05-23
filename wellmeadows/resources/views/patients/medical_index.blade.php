@extends('layouts.app')

@section('content')

<div class="topbar">
    <h2>Medical Records</h2>
    <div class="topbar-actions">
        <span class="topbar-date">{{ now()->format('d M Y') }}</span>
    </div>
</div>

<div class="content">

    {{-- Header --}}
    <div style="margin-bottom:24px;">
        <h3 style="color:#1a1f5e; font-size:18px; font-weight:700;">Select a Patient</h3>
        <p style="color:#888; font-size:13px; margin-top:4px;">Choose a patient below to view or manage their medical records.</p>
    </div>

    {{-- Patient List --}}
    <div style="background:white; border-radius:12px; padding:24px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <h3 style="color:#1a1f5e; font-size:15px; font-weight:700;">All Patients</h3>
            <input type="text" id="searchInput" placeholder="🔍  Search patient..."
                style="padding:8px 14px; border:1px solid #eee; border-radius:8px; font-size:12px; width:260px; outline:none;"
                onkeyup="searchTable()">
        </div>

        <table style="width:100%; border-collapse:collapse; font-size:13px;">
            <thead>
                <tr style="border-bottom:2px solid #f0f0f0; color:#aaa; text-transform:uppercase; font-size:10px; letter-spacing:1px;">
                    <th style="padding:10px 12px; text-align:left;">Patient</th>
                    <th style="padding:10px 12px; text-align:left;">Patient No.</th>
                    <th style="padding:10px 12px; text-align:left;">Date of Birth</th>
                    <th style="padding:10px 12px; text-align:left;">Status</th>
                    <th style="padding:10px 12px; text-align:left;">Action</th>
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
                            <div>
                                <div style="font-weight:600; color:#1a1f5e;">{{ $patient->first_name }} {{ $patient->last_name }}</div>
                                <div style="font-size:11px; color:#aaa;">Registered {{ \Carbon\Carbon::parse($patient->date_registered)->format('d M Y') }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="padding:12px; color:#888;">{{ $patient->patient_no }}</td>
                    <td style="padding:12px; color:#888;">{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('d M Y') }}</td>
                    <td style="padding:12px;">
                        <span style="padding:4px 12px; border-radius:20px; font-size:11px; font-weight:700;
                            background:{{ $patient->status == 'IN-PATIENT' ? '#d3f9d8' : '#fff3cd' }};
                            color:{{ $patient->status == 'IN-PATIENT' ? '#2b8a3e' : '#e67700' }};">
                            {{ $patient->status }}
                        </span>
                    </td>
                    <td style="padding:12px;">
                        <a href="{{ route('patients.medical', $patient->id) }}"
                            style="background:#1a1f5e; color:white; padding:6px 14px; border-radius:6px; font-size:11px; font-weight:600; text-decoration:none;">
                            View Records →
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding:32px; text-align:center; color:#ccc; font-size:13px;">No patients found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('scripts')
<script>
function searchTable() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#patientTable tr');
    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(input) ? '' : 'none';
    });
}
</script>
@endsection