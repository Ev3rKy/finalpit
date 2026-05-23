@extends('layouts.app')
@section('page-title', 'Dashboard')

@section('content')

{{-- METRICS --}}
<div class="metrics">
  <div class="metric" style="border-top:3px solid #185FA5">
    <div class="metric-label">Total revenue</div>
    <div class="metric-value">
      {{ $totalRevenue >= 1000 ? '₱'.number_format($totalRevenue/1000,1).'k' : '₱'.number_format($totalRevenue) }}
    </div>
    <div class="metric-note" style="color:#3B6D11">Paid bills only</div>
  </div>
  <div class="metric" style="border-top:3px solid #378ADD">
    <div class="metric-label">Bills generated</div>
    <div class="metric-value">{{ $billCount }}</div>
    <div class="metric-note muted">{{ now()->format('F Y') }}</div>
  </div>
  <div class="metric" style="border-top:3px solid #E24B4A">
    <div class="metric-label">Outstanding</div>
    <div class="metric-value">
      {{ $outstandingAmt >= 1000 ? '₱'.number_format($outstandingAmt/1000,1).'k' : '₱'.number_format($outstandingAmt) }}
    </div>
    <div class="metric-note" style="color:#A32D2D">{{ $unpaidCount }} unpaid</div>
  </div>
  <div class="metric" style="border-top:3px solid #1D9E75">
    <div class="metric-label">Occupancy</div>
    <div class="metric-value">{{ $occupancyPct }}%</div>
    <div class="metric-note" style="color:#3B6D11">{{ $occupiedBeds }}/{{ $totalBeds }} beds</div>
  </div>
</div>

@if($billCount === 0)
{{-- Empty state --}}
<div class="card" style="text-align:center;padding:48px 24px">
  <div style="font-size:40px;margin-bottom:12px">🏥</div>
  <div style="font-weight:600;font-size:15px;margin-bottom:6px">No bills yet</div>
  <div class="muted" style="margin-bottom:20px">Generate your first bill to get started.</div>
  <a href="{{ route('bills.create') }}" class="btn btn-primary">+ Generate first bill</a>
</div>
@else

<div class="two-col">

  {{-- Recent bills --}}
  <div class="card">
    <div class="card-top">
      <div class="card-title">Recent bills</div>
      <a href="{{ route('bills.index') }}" class="badge b-blue" style="text-decoration:none">View all</a>
    </div>
    @forelse($recentBills as $bill)
    <div class="bill-row">
      <div style="display:flex;align-items:center;gap:8px">
        <div class="avatar">{{ $bill->initials }}</div>
        <div>
          <div style="font-weight:600;color:#1E293B">{{ $bill->patient_name }}</div>
          <div class="muted" style="font-size:11px">{{ $bill->service }}</div>
        </div>
      </div>
      <div style="text-align:right">
        <div style="font-weight:600">{{ $bill->formatted_amount }}</div>
        {!! $bill->status_badge !!}
      </div>
    </div>
    @empty
    <div class="muted" style="padding:12px 0">No bills yet.</div>
    @endforelse
  </div>

  {{-- Outstanding --}}
  <div class="card">
    <div class="card-top">
      <div class="card-title">Outstanding &amp; overdue</div>
      <a href="{{ route('bills.outstanding') }}" class="badge b-red" style="text-decoration:none">{{ $unpaidCount }} unpaid</a>
    </div>
    @if($unpaidCount === 0)
      <div class="muted" style="padding:12px 0">No outstanding bills 🎉</div>
    @else
    <table>
      <thead>
        <tr>
          <th style="width:20%">Bill no.</th>
          <th style="width:28%">Patient</th>
          <th style="width:20%">Amount</th>
          <th style="width:15%">Status</th>
          <th style="width:17%"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($outstandingBills as $bill)
        <tr>
          <td class="muted">{{ $bill->bill_no }}</td>
          <td style="font-weight:600">{{ $bill->patient_name }}</td>
          <td style="font-weight:600">{{ $bill->formatted_amount }}</td>
          <td>{!! $bill->status_badge !!}</td>
          <td>
            <form method="POST" action="{{ route('bills.pay', $bill) }}" style="margin:0">
              @csrf @method('PATCH')
              <button type="submit" class="mpbtn">Mark paid</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @endif
  </div>

</div>
@endif
@endsection
