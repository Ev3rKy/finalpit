@extends('layouts.app')
@section('page-title', 'Edit Bill')

@section('content')
<div class="overlay">
  <div class="modal">
    <div class="modal-title">Edit bill</div>
    <div class="muted" style="font-size:11px;margin-bottom:16px">{{ $bill->bill_no }} · Created {{ $bill->created_at->format('F d, Y') }}</div>

    <form method="POST" action="{{ route('bills.update', $bill) }}">
      @csrf @method('PUT')

      <div class="field">
        <label>Patient full name *</label>
        <input type="text" name="patient_name" value="{{ old('patient_name', $bill->patient_name) }}" required>
        @error('patient_name')<div class="field-error">{{ $message }}</div>@enderror
      </div>

      <div class="field-row">
        <div class="field">
          <label>Patient ID *</label>
          <input type="text" name="patient_id" value="{{ old('patient_id', $bill->patient_id) }}" required>
          @error('patient_id')<div class="field-error">{{ $message }}</div>@enderror
        </div>
        <div class="field">
          <label>Ward *</label>
          <select name="ward_id" required>
            <option value="">Select ward</option>
            @foreach($wards as $ward)
              <option value="{{ $ward->id }}" {{ old('ward_id', $bill->ward_id)==$ward->id ? 'selected':'' }}>
                {{ $ward->name }}
              </option>
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
            <option value="{{ $service }}" {{ old('service', $bill->service)===$service ? 'selected':'' }}>
              {{ $service }}
            </option>
          @endforeach
        </select>
        @error('service')<div class="field-error">{{ $message }}</div>@enderror
      </div>

      <div class="field-row">
        <div class="field">
          <label>Amount (₱) *</label>
          <input type="number" name="amount" value="{{ old('amount', $bill->amount) }}" min="1" required>
          @error('amount')<div class="field-error">{{ $message }}</div>@enderror
        </div>
        <div class="field">
          <label>Due date</label>
          <input type="date" name="due_date" value="{{ old('due_date', $bill->due_date?->format('Y-m-d')) }}">
        </div>
      </div>

      <div class="field">
        <label>Status *</label>
        <select name="status" required>
          <option value="pending" {{ old('status', $bill->status)==='pending' ? 'selected':'' }}>Pending</option>
          <option value="paid"    {{ old('status', $bill->status)==='paid'    ? 'selected':'' }}>Paid</option>
          <option value="overdue" {{ old('status', $bill->status)==='overdue' ? 'selected':'' }}>Overdue</option>
        </select>
      </div>

      <div style="display:flex;gap:10px;margin-top:6px">
        <a href="{{ route('bills.index') }}" class="btn" style="flex:1;text-align:center">Cancel</a>
        <button type="submit" class="btn btn-primary" style="flex:2">Save changes</button>
      </div>
    </form>
  </div>
</div>
@endsection
