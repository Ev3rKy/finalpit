<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit {{ $staff->first_name }} — Wellmeadows</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --navy:#1a2557; --navy2:#232d6b; --teal:#00c9a7; --teal2:#00b096; --bg:#f0f2f5; --white:#ffffff; --border:#e2e8f0; --text:#1e293b; --muted:#64748b; --err:#e53e3e; --card:#ffffff; }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',sans-serif; background:var(--bg); color:var(--text); font-size:13px; height:100vh; overflow:hidden; display:flex; }
        .sb { width:220px; background:var(--navy); display:flex; flex-direction:column; flex-shrink:0; height:100vh; }
        .sb-brand { padding:20px 18px 16px; border-bottom:1px solid rgba(255,255,255,.08); }
        .sb-logo { font-size:18px; font-weight:700; color:#fff; }
        .sb-logo span { color:var(--teal); }
        .sb-ver { font-size:10px; color:rgba(255,255,255,.3); margin-top:2px; }
        .sb-nav { padding:16px 0; flex:1; }
        .nav-lbl { padding:8px 18px 4px; font-size:9px; font-weight:600; color:rgba(255,255,255,.3); text-transform:uppercase; letter-spacing:.12em; }
        .ni { display:flex; align-items:center; gap:10px; padding:10px 18px; color:rgba(255,255,255,.6); font-size:12px; text-decoration:none; border-left:3px solid transparent; }
        .ni:hover { background:rgba(255,255,255,.07); color:#fff; }
        .ni.on { background:rgba(0,201,167,.1); color:var(--teal); border-left-color:var(--teal); font-weight:500; }
        .sb-footer { padding:14px 18px; border-top:1px solid rgba(255,255,255,.08); font-size:10px; color:rgba(255,255,255,.3); }
        .main { flex:1; display:flex; flex-direction:column; overflow:hidden; }
        .topbar { background:var(--navy); padding:0 28px; display:flex; align-items:center; justify-content:space-between; height:60px; flex-shrink:0; }
        .tb-title { font-size:11px; font-weight:700; color:rgba(255,255,255,.5); text-transform:uppercase; letter-spacing:.1em; }
        .tb-page { font-size:16px; font-weight:700; color:#fff; margin-top:1px; }
        .av { width:36px; height:36px; border-radius:50%; background:var(--teal); color:#fff; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; }
        .content { flex:1; overflow-y:auto; padding:24px 28px; }
        .bc { display:flex; align-items:center; gap:6px; font-size:11px; color:var(--muted); margin-bottom:16px; }
        .bc a { color:var(--teal); text-decoration:none; }
        .ph { margin-bottom:20px; }
        .ph-title { font-size:18px; font-weight:700; color:var(--text); }
        .ph-sub { font-size:11px; color:var(--muted); margin-top:2px; }
        .card { background:var(--card); border-radius:10px; border:1px solid var(--border); overflow:hidden; }
        .card-hd { padding:16px 20px; border-bottom:1px solid var(--border); background:#f8fafc; }
        .card-title { font-size:14px; font-weight:600; color:var(--text); }
        .card-body { padding:20px; }
        .fg { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
        .fgp { display:flex; flex-direction:column; gap:5px; }
        .fgp.full { grid-column:1/-1; }
        .fsec { grid-column:1/-1; font-size:13px; font-weight:700; color:var(--navy); padding:10px 0 8px; border-bottom:2px solid var(--border); margin-top:6px; text-transform:uppercase; letter-spacing:.05em; }
        label { font-size:10px; font-weight:600; color:var(--muted); text-transform:uppercase; letter-spacing:.05em; }
        input, select { padding:9px 12px; border:1.5px solid var(--border); border-radius:8px; font-size:12px; font-family:'Inter',sans-serif; color:var(--text); outline:none; background:var(--white); }
        input:focus, select:focus { border-color:var(--teal); box-shadow:0 0 0 3px rgba(0,201,167,.1); }
        input:disabled { background:#f8fafc; color:var(--muted); }
        .fa { display:flex; gap:10px; justify-content:flex-end; padding-top:20px; border-top:1px solid var(--border); margin-top:8px; grid-column:1/-1; }
        .btn { display:inline-flex; align-items:center; padding:9px 20px; border-radius:8px; font-size:12px; font-weight:600; cursor:pointer; border:none; font-family:'Inter',sans-serif; text-decoration:none; }
        .b-teal { background:var(--teal); color:#fff; }
        .b-teal:hover { background:var(--teal2); }
        .b-ol { background:transparent; color:var(--navy); border:1.5px solid var(--border); }
    </style>
</head>
<body>

<div class="sb">
    <div class="sb-brand">
        <div class="sb-logo">Well<span>meadows</span></div>
        <div class="sb-ver">Hospital Management System</div>
    </div>
    <div class="sb-nav">
        <div class="nav-lbl">Staff Module</div>
        <a href="{{ route('staff.index') }}" class="ni on">👥 Staff Directory</a>
        <a href="{{ route('staff.create') }}" class="ni">＋ Add Staff</a>
        <a href="{{ route('ward-allocation.index') }}" class="ni">📅 Ward Allocation</a>
        <div class="nav-lbl" style="margin-top:8px">System</div>
        <a href="/" class="ni">🏠 Home</a>
    </div>
    <div class="sb-footer">Wellmeadows v1.0</div>
</div>

<div class="main">
    <div class="topbar">
        <div>
            <div class="tb-title">Staff Module</div>
            <div class="tb-page">Edit Staff Member</div>
        </div>
        <div style="display:flex;align-items:center;gap:12px">
            <div style="font-size:12px;color:rgba(255,255,255,.6)">{{ date('d M Y') }}</div>
            <div class="av">PO</div>
        </div>
    </div>

    <div class="content">
        <div class="bc">
            <a href="{{ route('staff.index') }}">Staff Directory</a>
            <span>›</span>
            <a href="{{ route('staff.show', $staff->staff_number) }}">{{ $staff->first_name }} {{ $staff->last_name }}</a>
            <span>›</span>
            <span>Edit</span>
        </div>

        <div class="ph">
            <div class="ph-title">Edit Staff Member</div>
            <div class="ph-sub">{{ $staff->first_name }} {{ $staff->last_name }} — {{ $staff->staff_number }}</div>
        </div>

        <div class="card">
            <div class="card-hd"><div class="card-title">Update Staff Details</div></div>
            <div class="card-body">
                <form action="{{ route('staff.update', $staff->staff_number) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="fg">
                        <div class="fsec">Personal Information</div>

                        <div class="fgp">
                            <label>Staff Number</label>
                            <input type="text" value="{{ $staff->staff_number }}" disabled>
                        </div>
                        <div class="fgp">
                            <label>First Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name', $staff->first_name) }}">
                        </div>
                        <div class="fgp">
                            <label>Last Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name', $staff->last_name) }}">
                        </div>
                        <div class="fgp full">
                            <label>Full Address</label>
                            <input type="text" name="address" value="{{ old('address', $staff->address) }}">
                        </div>
                        <div class="fgp">
                            <label>Telephone</label>
                            <input type="text" name="tel_no" value="{{ old('tel_no', $staff->tel_no) }}">
                        </div>
                        <div class="fgp">
                            <label>Date of Birth</label>
                            <input type="date" name="dob" value="{{ old('dob', $staff->dob) }}">
                        </div>
                        <div class="fgp">
                            <label>Sex</label>
                            <select name="sex">
                                <option value="M" {{ $staff->sex=='M'?'selected':'' }}>Male</option>
                                <option value="F" {{ $staff->sex=='F'?'selected':'' }}>Female</option>
                            </select>
                        </div>
                        <div class="fgp">
                            <label>NIN</label>
                            <input type="text" name="nin" value="{{ old('nin', $staff->nin) }}">
                        </div>

                        <div class="fsec">Employment Details</div>

                        <div class="fgp">
                            <label>Position</label>
                            <select name="position">
                                @foreach(['Charge Nurse','Staff Nurse','Nurse','Consultant','Doctor','Auxiliary'] as $p)
                                <option value="{{ $p }}" {{ $staff->position==$p?'selected':'' }}>{{ $p }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="fgp">
                            <label>Current Salary</label>
                            <input type="number" name="current_salary" value="{{ old('current_salary', $staff->current_salary) }}" step="0.01">
                        </div>
                        <div class="fgp">
                            <label>Salary Scale</label>
                            <input type="text" name="salary_scale" value="{{ old('salary_scale', $staff->salary_scale) }}">
                        </div>
                        <div class="fgp">
                            <label>Hours per Week</label>
                            <input type="number" name="hours_per_week" value="{{ old('hours_per_week', $staff->hours_per_week) }}" step="0.5">
                        </div>
                        <div class="fgp">
                            <label>Contract Type</label>
                            <select name="contract_type">
                                <option value="Permanent" {{ $staff->contract_type=='Permanent'?'selected':'' }}>Permanent</option>
                                <option value="Temporary" {{ $staff->contract_type=='Temporary'?'selected':'' }}>Temporary</option>
                            </select>
                        </div>
                        <div class="fgp">
                            <label>Payment Type</label>
                            <select name="payment_type">
                                <option value="Weekly" {{ $staff->payment_type=='Weekly'?'selected':'' }}>Weekly</option>
                                <option value="Monthly" {{ $staff->payment_type=='Monthly'?'selected':'' }}>Monthly</option>
                            </select>
                        </div>

                        <div class="fa">
                            <a href="{{ route('staff.show', $staff->staff_number) }}" class="btn b-ol">Cancel</a>
                            <button type="submit" class="btn b-teal">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>