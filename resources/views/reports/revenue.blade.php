@extends('layouts.app')
@section('page-title', 'Revenue Report')

@section('content')
<div class="card">
  <div class="card-top">
    <div class="card-title">Revenue report</div>
    <span class="badge b-blue">{{ now()->format('F Y') }}</span>
  </div>

  @foreach($buckets as $label => $total)
  @php $pct = $maxVal > 0 ? round(($total / $maxVal) * 100) : 0; @endphp
  <div style="margin-bottom:12px">
    <div style="display:flex;justify-content:space-between;margin-bottom:3px">
      <span class="muted">{{ $label }}</span>
      <span style="font-weight:600">₱{{ number_format($total) }}</span>
    </div>
    <div class="bar-track" style="height:10px">
      <div style="width:{{ $pct }}%;height:100%;background:#185FA5;border-radius:4px;transition:width 0.4s"></div>
    </div>
  </div>
  @endforeach

  <div class="divider"></div>
  <div style="display:flex;justify-content:space-between;margin-bottom:5px">
    <span class="muted">Subtotal</span><span>₱{{ number_format($subtotal) }}</span>
  </div>
  <div style="display:flex;justify-content:space-between;margin-bottom:5px">
    <span class="muted">Discounts (2.5%)</span>
    <span style="color:#A32D2D">-₱{{ number_format($discount) }}</span>
  </div>
  <div style="display:flex;justify-content:space-between;font-weight:600">
    <span class="muted">Net revenue</span>
    <span style="color:#185FA5">₱{{ number_format($net) }}</span>
  </div>
</div>
@endsection
