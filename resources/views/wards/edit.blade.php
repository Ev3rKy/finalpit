@extends('layouts.app')
@section('page-title', 'Edit Ward')

@section('content')
<div class="overlay">
  <div class="modal">
    <div class="modal-title">Edit ward</div>
    <div class="muted" style="font-size:11px;margin-bottom:16px">{{ $ward->name }}</div>

    <form method="POST" action="{{ route('wards.update', $ward) }}">
      @csrf @method('PUT')

      <div class="field">
        <label>Ward name *</label>
        <input type="text" name="name" value="{{ old('name', $ward->name) }}" required>
        @error('name')<div class="field-error">{{ $message }}</div>@enderror
      </div>

      <div class="field-row">
        <div class="field">
          <label>Total beds *</label>
          <input type="number" name="total_beds" value="{{ old('total_beds', $ward->total_beds) }}" min="1" required>
          @error('total_beds')<div class="field-error">{{ $message }}</div>@enderror
        </div>
        <div class="field">
          <label>Occupied beds</label>
          <input type="number" name="occupied_beds" value="{{ old('occupied_beds', $ward->occupied_beds) }}" min="0" disabled
                 style="background:#F1F5F9;color:#94A3B8;cursor:not-allowed">
          <div style="font-size:10px;color:#94A3B8;margin-top:3px">Auto-calculated from active bills</div>
        </div>
      </div>

      <div style="display:flex;gap:10px;margin-top:6px">
        <a href="{{ route('wards.index') }}" class="btn" style="flex:1;text-align:center">Cancel</a>
        <button type="submit" class="btn btn-primary" style="flex:2">Save changes</button>
      </div>
    </form>
  </div>
</div>
@endsection