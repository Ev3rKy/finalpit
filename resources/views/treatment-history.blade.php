@extends('layouts.app')

@section('content')
<div class="card" style="max-width:1100px; margin:0 auto;">
    <div class="card-title">Treatment History</div>

    <form method="GET" action="{{ route('treatment-history') }}" style="display:flex; gap:24px; margin-bottom:24px; align-items:flex-end;">
        <div>
            <label class="form-label">Month</label>
            <div class="form-select-wrap" style="min-width:160px;">
                <select class="form-select" name="month" onchange="this.form.submit()">
                    <option value="">All Months</option>
                    @php
                        $months = [1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',
                                   7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December'];
                    @endphp
                    @foreach($months as $num => $name)
                        <option value="{{ $num }}" {{ request('month') == $num ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <label class="form-label">Year</label>
            <div class="form-select-wrap" style="min-width:120px;">
                <select class="form-select" name="year" onchange="this.form.submit()">
                    <option value="">All Years</option>
                    @for($y = date('Y'); $y >= 1900; $y--)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
        </div>
    </form>

    <div style="overflow-x:auto; border-radius:10px; overflow:hidden;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Age</th>
                    <th>Birthdate</th>
                    <th>Doctor</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Procedure</th>
                    <th>Vitals</th>
                    <th>Med Notes</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $rec)
                    @php
                        $dt = \Carbon\Carbon::parse($rec->treatment_datetime);
                        $vitals = implode(', ', array_filter([$rec->bp, $rec->temperature, $rec->spo2]));
                    @endphp
                    <tr>
                        <td>{{ strtoupper($rec->patient_full_name) }}</td>
                        <td>{{ $rec->age }}</td>
                        <td>{{ $rec->birth_date ? \Carbon\Carbon::parse($rec->birth_date)->format('m/d/Y') : '—' }}</td>
                        <td>{{ strtoupper($rec->doctor) }}</td>
                        <td>{{ $dt->format('m/d/Y') }}</td>
                        <td>{{ $dt->format('g:iA') }}</td>
                        <td>{{ strtoupper($rec->procedure) }}</td>
                        <td>{{ $vitals ?: '—' }}</td>
                        <td>
                            <button
                                onclick="openModal(
                                    '{{ addslashes(strtoupper($rec->patient_full_name)) }}',
                                    '{{ $rec->age }}',
                                    '{{ $rec->birth_date ? \Carbon\Carbon::parse($rec->birth_date)->format('m/d/Y') : '' }}',
                                    '{{ addslashes(strtoupper($rec->doctor)) }}',
                                    '{{ $dt->format('m/d/Y') }}',
                                    '{{ $dt->format('g:iA') }}',
                                    '{{ addslashes(strtoupper($rec->procedure)) }}',
                                    '{{ addslashes($vitals) }}',
                                    `{{ addslashes(strip_tags($rec->medical_notes ?? '')) }}`
                                )"
                                style="background:none; border:none; cursor:pointer; color:var(--navy); font-size:1.2rem;"
                                title="View Medical Notes"
                            >
                                📋
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="padding:32px; color:#999; font-size:0.82rem;">No records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL --}}
<div id="notes-modal" style="display:none; position:fixed; inset:0; background:rgba(30,42,74,0.55); z-index:999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:16px; padding:40px; max-width:560px; width:90%; max-height:80vh; overflow-y:auto; position:relative;">
        <button onclick="closeModal()" style="position:absolute; top:16px; right:20px; background:none; border:none; font-size:1.4rem; font-weight:700; color:var(--navy); cursor:pointer;">✕</button>
        <div id="modal-content" style="font-family:'Jost',sans-serif; font-size:0.9rem; color:#1e2a4a; line-height:1.9;"></div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openModal(name, age, birthdate, doctor, date, time, procedure, vitals, notes) {
    document.getElementById('modal-content').innerHTML =
        `<strong>PATIENT NAME:</strong> ${name}<br>
         <strong>AGE:</strong> ${age} Y.O.<br>
         <strong>BIRTHDATE:</strong> ${birthdate}<br>
         <strong>DOCTOR:</strong> ${doctor}<br>
         <strong>TREATMENT DATE&TIME:</strong> ${date}, ${time}<br>
         <strong>PROCEDURE:</strong> ${procedure}<br>
         <strong>VITALS:</strong> BP: ${vitals}<br><br>
         <strong>MEDICAL NOTE:</strong><br>${notes}`;
    document.getElementById('notes-modal').style.display = 'flex';
}
function closeModal() {
    document.getElementById('notes-modal').style.display = 'none';
}
// Close when clicking outside
document.getElementById('notes-modal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
@endpush
