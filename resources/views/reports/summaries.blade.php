@extends('layouts.app')
@section('page-title', 'Summaries')

@section('content')
<div class="card">
  <div class="card-top">
    <div class="card-title">Hospital management summary</div>
    <span class="badge b-blue">{{ now()->format('F Y') }}</span>
  </div>

  <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px">
    <div class="metric" style="border-top:3px solid #185FA5">
      <div class="metric-label">Total patients billed</div>
      <div class="metric-value">{{ $totalPatients }}</div>
      <div class="metric-note muted">This period</div>
    </div>
    <div class="metric" style="border-top:3px solid #378ADD">
      <div class="metric-label">Revenue collected</div>
      <div class="metric-value">₱{{ number_format($collected / 1000, 1) }}k</div>
      <div class="metric-note" style="color:#3B6D11">Paid bills only</div>
    </div>
    <div class="metric" style="border-top:3px solid #85B7EB">
      <div class="metric-label">Avg bill amount</div>
      <div class="metric-value">₱{{ number_format($avgBill / 1000, 1) }}k</div>
      <div class="metric-note muted">Per patient</div>
    </div>
    <div class="metric" style="border-top:3px solid #1D9E75">
      <div class="metric-label">Collection rate</div>
      <div class="metric-value">{{ $collectionRate }}%</div>
      <div class="metric-note" style="{{ $collectionRate >= 90 ? 'color:#3B6D11' : 'color:#A32D2D' }}">
        {{ $collectionRate >= 90 ? 'Above target' : 'Below target' }}
      </div>
    </div>
  </div>

  <div class="divider"></div>
  <div class="muted" style="margin-bottom:10px">Key notes</div>

  @foreach($wards as $ward)
    @if($ward->occupied_beds >= $ward->total_beds)
    <div class="note-line">
      <div class="note-bar" style="background:#185FA5"></div>
      <span>{{ $ward->name }} is fully occupied — consider patient transfers to other wards.</span>
    </div>
    @endif
  @endforeach

  @if($unpaidCount > 0)
  <div class="note-line">
    <div class="note-bar" style="background:#E24B4A"></div>
    <span>{{ $unpaidCount }} bills remain unpaid totaling ₱{{ number_format($outstandingAmt) }} in outstanding balance.</span>
  </div>
  @endif

  <div class="note-line">
    <div class="note-bar" style="background:#1D9E75"></div>
    <span>Collection rate is {{ $collectionRate }}% — {{ $collectionRate >= 90 ? 'above the 90% target.' : 'below the 90% target. Follow up on outstanding bills.' }}</span>
  </div>
</div>
@endsection
