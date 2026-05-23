@extends('layouts.app')
@section('page-title', 'Wards')

@section('content')
<div class="card">
  <div class="card-top">
    <div class="card-title">Ward management</div>
    <a href="{{ route('wards.create') }}" class="btn btn-primary">+ Add ward</a>
  </div>

  <table>
    <thead>
      <tr>
        <th style="width:20%">Ward name</th>
        <th style="width:15%">Total beds</th>
        <th style="width:15%">Occupied</th>
        <th style="width:15%">Available</th>
        <th style="width:15%">Occupancy</th>
        <th style="width:10%">Bills</th>
        <th style="width:10%">Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($wards as $ward)
      @php
        $pct   = $ward->total_beds > 0 ? round(($ward->occupied_beds / $ward->total_beds) * 100) : 0;
        $color = $pct >= 95 ? '#E24B4A' : ($pct >= 80 ? '#185FA5' : '#1D9E75');
      @endphp
      <tr>
        <td style="font-weight:600">{{ $ward->name }}</td>
        <td class="muted">{{ $ward->total_beds }}</td>
        <td style="font-weight:600;color:{{ $color }}">{{ $ward->occupied_beds }}</td>
        <td class="muted">{{ $ward->total_beds - $ward->occupied_beds }}</td>
        <td>
          <div style="display:flex;align-items:center;gap:6px">
            <div class="bar-track" style="flex:1;height:6px">
              <div style="width:{{ $pct }}%;height:100%;background:{{ $color }};border-radius:4px"></div>
            </div>
            <span style="font-size:11px;color:{{ $color }};font-weight:600;min-width:30px">{{ $pct }}%</span>
          </div>
        </td>
        <td class="muted">{{ $ward->bills_count }}</td>
        <td>
          <div style="display:flex;gap:4px">
            <a href="{{ route('wards.edit', $ward) }}" class="action-btn btn-edit">Edit</a>
            <form method="POST" action="{{ route('wards.destroy', $ward) }}" style="margin:0"
                  onsubmit="return confirm('Delete {{ $ward->name }}? This cannot be undone.')">
              @csrf @method('DELETE')
              <button type="submit" class="action-btn btn-delete">Delete</button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="7" style="padding:30px 0;text-align:center;color:#94A3B8">
          No wards yet. <a href="{{ route('wards.create') }}" style="color:#185FA5">Add the first ward →</a>
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection