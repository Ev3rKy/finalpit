@extends('layouts.staff')

@section('title', 'Add Staff — Wellmeadows')
@section('top_title', 'Add Staff Member')
@section('top_sub', 'STAFF REGISTRATION')

@section('content')
<div class="bc">
    <a href="{{ route('staff.index') }}">Staff Directory</a>
    <span>›</span><span>Add New Staff</span>
</div>

<div class="sh">
    <div>
        <div class="sh-title">Add Staff Member</div>
        <div class="sh-sub">Fields marked <span class="req">*</span> are required</div>
    </div>
</div>

<div class="card">
    <div class="card-hd"><div class="card-title">Staff Registration Form</div></div>
    <div class="card-body">
        <form action="{{ route('staff.store') }}" method="POST">
            @csrf
            <div class="fg">

                @if($errors->any())
                <div class="alert-err" style="grid-column:1/-1">
                    <strong>Please fix the following:</strong>
                    <ul style="margin-top:6px;padding-left:16px">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="fsec">Personal Information</div>

                <div class="fgp">
                    <label>Staff Number <span class="req">*</span></label>
                    <input type="text" name="staff_number" value="{{ old('staff_number') }}" placeholder="e.g. S011">
                    @error('staff_number')<span class="err-msg">{{ $message }}</span>@enderror
                </div>
                <div class="fgp">
                    <label>First Name <span class="req">*</span></label>
                    <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="First name">
                    @error('first_name')<span class="err-msg">{{ $message }}</span>@enderror
                </div>
                <div class="fgp">
                    <label>Last Name <span class="req">*</span></label>
                    <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Last name">
                    @error('last_name')<span class="err-msg">{{ $message }}</span>@enderror
                </div>
                <div class="fgp full">
                    <label>Full Address <span class="req">*</span></label>
                    <input type="text" name="address" value="{{ old('address') }}" placeholder="Street, City, Postcode">
                    @error('address')<span class="err-msg">{{ $message }}</span>@enderror
                </div>
                <div class="fgp">
                    <label>Telephone Number</label>
                    <input type="text" name="tel_no" value="{{ old('tel_no') }}" placeholder="e.g. 0131-334-5677">
                </div>
                <div class="fgp">
                    <label>Date of Birth <span class="req">*</span></label>
                    <input type="date" name="dob" value="{{ old('dob') }}">
                    @error('dob')<span class="err-msg">{{ $message }}</span>@enderror
                </div>
                <div class="fgp">
                    <label>Sex <span class="req">*</span></label>
                    <select name="sex">
                        <option value="">-- Select --</option>
                        <option value="M" {{ old('sex')=='M'?'selected':'' }}>Male</option>
                        <option value="F" {{ old('sex')=='F'?'selected':'' }}>Female</option>
                    </select>
                    @error('sex')<span class="err-msg">{{ $message }}</span>@enderror
                </div>
                <div class="fgp">
                    <label>NIN <span class="req">*</span></label>
                    <input type="text" name="nin" value="{{ old('nin') }}" placeholder="e.g. WB123423D">
                    @error('nin')<span class="err-msg">{{ $message }}</span>@enderror
                </div>

                <div class="fsec">Employment Details</div>

                <div class="fgp">
                    <label>Position <span class="req">*</span></label>
                    <select name="position">
                        <option value="">-- Select --</option>
                        @foreach(['Charge Nurse','Staff Nurse','Nurse','Consultant','Doctor','Auxiliary'] as $p)
                        <option value="{{ $p }}" {{ old('position')==$p?'selected':'' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                    @error('position')<span class="err-msg">{{ $message }}</span>@enderror
                </div>
                <div class="fgp">
                    <label>Current Salary <span class="req">*</span></label>
                    <input type="number" name="current_salary" value="{{ old('current_salary') }}" placeholder="e.g. 18760" step="0.01">
                    @error('current_salary')<span class="err-msg">{{ $message }}</span>@enderror
                </div>
                <div class="fgp">
                    <label>Salary Scale</label>
                    <input type="text" name="salary_scale" value="{{ old('salary_scale') }}" placeholder="e.g. 1C">
                </div>
                <div class="fgp">
                    <label>Hours per Week</label>
                    <input type="number" name="hours_per_week" value="{{ old('hours_per_week') }}" placeholder="e.g. 37.5" step="0.5">
                </div>
                <div class="fgp">
                    <label>Contract Type <span class="req">*</span></label>
                    <select name="contract_type">
                        <option value="">-- Select --</option>
                        <option value="Permanent" {{ old('contract_type')=='Permanent'?'selected':'' }}>Permanent</option>
                        <option value="Temporary" {{ old('contract_type')=='Temporary'?'selected':'' }}>Temporary</option>
                    </select>
                    @error('contract_type')<span class="err-msg">{{ $message }}</span>@enderror
                </div>
                <div class="fgp">
                    <label>Payment Type</label>
                    <select name="payment_type">
                        <option value="">-- Select --</option>
                        <option value="Weekly" {{ old('payment_type')=='Weekly'?'selected':'' }}>Weekly</option>
                        <option value="Monthly" {{ old('payment_type')=='Monthly'?'selected':'' }}>Monthly</option>
                    </select>
                </div>

                <div class="fa">
                    <a href="{{ route('staff.index') }}" class="btn b-ol">Cancel</a>
                    <button type="submit" class="btn b-nv">+ Save Staff Member</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
