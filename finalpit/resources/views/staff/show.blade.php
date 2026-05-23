@extends('layouts.staff')

@section('title', $staff->first_name . ' ' . $staff->last_name . ' — Wellmeadows')
@section('top_title', 'Staff Profile')
@section('top_sub', $staff->staff_number)

@section('content')
<div class="bc">
    <a href="{{ route('staff.index') }}">Staff Directory</a>
    <span>›</span>
    <span>{{ $staff->first_name }} {{ $staff->last_name }}</span>
</div>

<div class="pb">
    <div class="pav">{{ strtoupper(substr($staff->first_name,0,1).substr($staff->last_name,0,1)) }}</div>
    <div style="flex:1">
        <div class="pn">{{ $staff->first_name }} {{ $staff->last_name }}</div>
        <div class="pr">{{ $staff->position }}</div>
        <div class="pm">
            <span class="pmi">📋 {{ $staff->staff_number }}</span>
            <span class="pmi">📞 {{ $staff->tel_no ?? 'N/A' }}</span>
            <span class="bdg {{ $staff->contract_type=='Permanent'?'bp':'bt' }}" style="font-size:10px">{{ $staff->contract_type }}</span>
        </div>
    </div>
    <div style="display:flex;gap:8px">
        <a href="{{ route('staff.edit', $staff->staff_number) }}" class="btn b-ol" style="color:rgba(255,255,255,.8);border-color:rgba(255,255,255,.2)">✏ Edit</a>
        <form action="{{ route('staff.destroy', $staff->staff_number) }}" method="POST">
            @csrf @method('DELETE')
            <button type="submit" class="btn b-dn" onclick="return confirm('Delete this staff member?')">🗑 Delete</button>
        </form>
    </div>
</div>

<div class="pg">
    <div class="card">
        <div class="card-hd"><div class="card-title">Personal Details</div></div>
        <div class="card-body">
            <div class="dr"><span class="dl">First Name</span><span class="dv">{{ $staff->first_name }}</span></div>
            <div class="dr"><span class="dl">Last Name</span><span class="dv">{{ $staff->last_name }}</span></div>
            <div class="dr"><span class="dl">Date of Birth</span><span class="dv">{{ \Carbon\Carbon::parse($staff->dob)->format('d M Y') }}</span></div>
            <div class="dr"><span class="dl">Sex</span><span class="dv">{{ $staff->sex == 'M' ? 'Male' : 'Female' }}</span></div>
            <div class="dr"><span class="dl">NIN</span><span class="dv mono">{{ $staff->nin }}</span></div>
            <div class="dr"><span class="dl">Address</span><span class="dv">{{ $staff->address }}</span></div>
            <div class="dr"><span class="dl">Telephone</span><span class="dv">{{ $staff->tel_no ?? 'N/A' }}</span></div>
        </div>
    </div>
    <div class="card">
        <div class="card-hd"><div class="card-title">Employment Details</div></div>
        <div class="card-body">
            <div class="dr"><span class="dl">Position</span><span class="dv">{{ $staff->position }}</span></div>
            <div class="dr"><span class="dl">Current Salary</span><span class="dv">£{{ number_format($staff->current_salary, 2) }}</span></div>
            <div class="dr"><span class="dl">Salary Scale</span><span class="dv">{{ $staff->salary_scale ?? 'N/A' }}</span></div>
            <div class="dr"><span class="dl">Hours / Week</span><span class="dv">{{ $staff->hours_per_week ?? 'N/A' }}</span></div>
            <div class="dr"><span class="dl">Contract</span><span class="dv"><span class="bdg {{ $staff->contract_type=='Permanent'?'bp':'bt' }}">{{ $staff->contract_type }}</span></span></div>
            <div class="dr"><span class="dl">Payment Type</span><span class="dv">{{ $staff->payment_type ?? 'N/A' }}</span></div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-hd">
        <div class="tabs">
            <div class="tab on" onclick="switchTab(this,'tQ')">Qualifications</div>
            <div class="tab" onclick="switchTab(this,'tE')">Work Experience</div>
        </div>
        <div style="display:flex;gap:8px">
            <button type="button" class="btn b-nv b-sm" onclick="toggleForm('qForm')">+ Qualification</button>
            <button type="button" class="btn b-ol b-sm" onclick="toggleForm('eForm')">+ Experience</button>
        </div>
    </div>

    <div class="inline-form" id="qForm">
        <form action="{{ route('staff.qualifications.store', $staff->staff_number) }}" method="POST">
            @csrf
            <div class="if-grid if-grid-3">
                <div class="fgp"><label>Qualification Type *</label><input type="text" name="qualification_type" placeholder="e.g. BSc Nursing Studies" required></div>
                <div class="fgp"><label>Date Obtained</label><input type="date" name="date_obtained"></div>
                <div class="fgp"><label>Institution</label><input type="text" name="institution" placeholder="e.g. Edinburgh University"></div>
                <div style="display:flex;gap:6px;align-items:flex-end;padding-bottom:1px">
                    <button type="submit" class="btn b-nv b-sm">Save</button>
                    <button type="button" class="btn b-ol b-sm" onclick="toggleForm('qForm')">Cancel</button>
                </div>
            </div>
        </form>
    </div>

    <div class="inline-form" id="eForm">
        <form action="{{ route('staff.experience.store', $staff->staff_number) }}" method="POST">
            @csrf
            <div class="if-grid if-grid-4">
                <div class="fgp"><label>Position *</label><input type="text" name="position" placeholder="e.g. Staff Nurse" required></div>
                <div class="fgp"><label>Start Date</label><input type="date" name="start_date"></div>
                <div class="fgp"><label>Finish Date</label><input type="date" name="finish_date"></div>
                <div class="fgp"><label>Organisation *</label><input type="text" name="organisation" placeholder="e.g. Western Hospital" required></div>
                <div style="display:flex;gap:6px;align-items:flex-end;padding-bottom:1px">
                    <button type="submit" class="btn b-nv b-sm">Save</button>
                    <button type="button" class="btn b-ol b-sm" onclick="toggleForm('eForm')">Cancel</button>
                </div>
            </div>
        </form>
    </div>

    <div id="tQ">
        <table class="stbl">
            <thead><tr><th>Qualification Type</th><th>Date Obtained</th><th>Institution</th></tr></thead>
            <tbody>
                @forelse($staff->qualifications as $q)
                <tr>
                    <td>{{ $q->qualification_type }}</td>
                    <td>{{ $q->date_obtained ? \Carbon\Carbon::parse($q->date_obtained)->format('d M Y') : 'N/A' }}</td>
                    <td>{{ $q->institution ?? 'N/A' }}</td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center;padding:24px;color:var(--muted)">No qualifications added yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div id="tE" style="display:none">
        <table class="stbl">
            <thead><tr><th>Position</th><th>Start Date</th><th>Finish Date</th><th>Organisation</th></tr></thead>
            <tbody>
                @forelse($staff->workExperiences as $e)
                <tr>
                    <td>{{ $e->position }}</td>
                    <td>{{ $e->start_date ? \Carbon\Carbon::parse($e->start_date)->format('d M Y') : 'N/A' }}</td>
                    <td>{{ $e->finish_date ? \Carbon\Carbon::parse($e->finish_date)->format('d M Y') : 'N/A' }}</td>
                    <td>{{ $e->organisation }}</td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;padding:24px;color:var(--muted)">No work experience added yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
function switchTab(el, id) {
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('on'));
    el.classList.add('on');
    document.getElementById('tQ').style.display = id === 'tQ' ? 'block' : 'none';
    document.getElementById('tE').style.display = id === 'tE' ? 'block' : 'none';
}
function toggleForm(id) {
    document.getElementById(id).classList.toggle('show');
}
</script>
@endpush
