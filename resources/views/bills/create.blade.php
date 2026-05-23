@extends('layouts.app')
@section('page-title', 'Generate Bill')

@section('content')
<div class="overlay">
  <div class="modal">
    <div class="modal-title">Generate new bill</div>
    <div class="muted" style="font-size:11px;margin-bottom:16px">{{ $nextBillNo }} · {{ now()->format('F d, Y') }}</div>

    <form method="POST" action="{{ route('bills.store') }}">
      @csrf

      <div class="field">
        <label>Patient full name *</label>
        <input type="text" name="patient_name" value="{{ old('patient_name') }}" placeholder="e.g. Juan Dela Cruz" required>
        @error('patient_name')<div class="field-error">{{ $message }}</div>@enderror
      </div>

      <div class="field-row">
        <div class="field">
          <label>Patient ID *</label>
          <input type="text" name="patient_id" value="{{ old('patient_id') }}" placeholder="e.g. P-001" required>
          @error('patient_id')<div class="field-error">{{ $message }}</div>@enderror
        </div>
        <div class="field">
          <label>Ward *</label>
          <select name="ward_id" required>
            <option value="">Select ward</option>
            @foreach($wards as $ward)
              <option value="{{ $ward->id }}" {{ old('ward_id')==$ward->id?'selected':'' }}>{{ $ward->name }}</option>
            @endforeach
          </select>
          @error('ward_id')<div class="field-error">{{ $message }}</div>@enderror
        </div>
      </div>

      <div class="field">
        <label>Service type *</label>
        <select name="service" required>
          <option value="">Select service</option>
          @foreach($services as $service)
            <option value="{{ $service }}" {{ old('service')===$service?'selected':'' }}>{{ $service }}</option>
          @endforeach
        </select>
        @error('service')<div class="field-error">{{ $message }}</div>@enderror
      </div>

      <div class="field-row">
        <div class="field">
          <label>Amount (₱) *</label>
          <input type="number" name="amount" value="{{ old('amount') }}" placeholder="e.g. 12500" min="1" required>
          @error('amount')<div class="field-error">{{ $message }}</div>@enderror
        </div>
        <div class="field">
          <label>Due date</label>
          <input type="date" name="due_date" value="{{ old('due_date') }}">
        </div>
      </div>

      <div class="field">
        <label>Status *</label>
        <select name="status" required>
          <option value="pending" {{ old('status','pending')==='pending'?'selected':'' }}>Pending</option>
          <option value="paid"    {{ old('status')==='paid'   ?'selected':'' }}>Paid</option>
          <option value="overdue" {{ old('status')==='overdue'?'selected':'' }}>Overdue</option>
        </select>
      </div>

      <div style="display:flex;gap:10px;margin-top:6px">
        <a href="{{ route('bills.index') }}" class="btn" style="flex:1;text-align:center">Cancel</a>
        <button type="submit" class="btn btn-primary" style="flex:2">Generate bill</button>
      </div>
    </form>
  </div>
</div>
@endsection
