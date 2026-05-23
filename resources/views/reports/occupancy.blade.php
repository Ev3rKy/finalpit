@extends('layouts.app')
@section('page-title', 'Occupancy Rate')

@section('content')
<div class="card">
  <div class="card-top">
    <div class="card-title">Occupancy rate</div>
    <span class="badge b-blue">{{ now()->format('F Y') }}</span>
  </div>

  <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px">
    <div class="metric" style="border-top:3px solid #185FA5">
      <div class="metric-label">Total beds</div>
      <div class="metric-value">{{ $totalBeds }}</div>
    </div>
    <div class="metric" style="border-top:3px solid #378ADD">
      <div class="metric-label">Occupied</div>
      <div class="metric-value" style="color:#185FA5">{{ $occupiedBeds }}</div>
    </div>
    <div class="metric" style="border-top:3px solid #85B7EB">
      <div class="metric-label">Available</div>
      <div class="metric-value" style="color:#3B6D11">{{ $availBeds }}</div>
    </div>
    <div class="metric" style="border-top:3px solid #1D9E75">
      <div class="metric-label">Rate</div>
      <div class="metric-value">{{ $rate }}%</div>
    </div>
  </div>

  <div class="divider"></div>
  <div class="muted" style="margin-bottom:12px">Ward breakdown</div>

  @foreach($wards as $ward)
  @php
    $pct = $ward->total_beds > 0 ? round(($ward->occupied_beds / $ward->total_beds) * 100) : 0;
    $color = $pct >= 95 ? '#E24B4A' : ($pct >= 80 ? '#185FA5' : '#85B7EB');
  @endphp
  <div style="margin-bottom:9px">
    <div style="display:flex;justify-content:space-between;margin-bottom:3px">
      <span class="muted">{{ $ward->name }}</span>
      <span style="font-weight:600;color:{{ $color }}">
        {{ $ward->occupied_beds }}/{{ $ward->total_beds }} — {{ $pct }}%
      </span>
    </div>
    <div class="bar-track" style="height:6px">
      <div style="width:{{ $pct }}%;height:100%;background:{{ $color }};border-radius:4px"></div>
    </div>
  </div>
  @endforeach
</div>
@endsection
