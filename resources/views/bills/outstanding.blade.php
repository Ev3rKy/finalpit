@extends('layouts.app')
@section('page-title', 'Outstanding')

@section('content')
<div class="card">
  <div class="card-top">
    <div class="card-title">Outstanding &amp; overdue bills</div>
    <span class="badge b-red">{{ $unpaidCount }} unpaid</span>
  </div>

  <div style="display:flex;gap:12px;margin-bottom:16px">
    <div class="metric" style="border-top:3px solid #E24B4A;flex:1">
      <div class="metric-label">Total outstanding</div>
      <div class="metric-value" style="font-size:18px">₱{{ number_format($outstandingAmt) }}</div>
    </div>
    <div class="metric" style="border-top:3px solid #378ADD;flex:1">
      <div class="metric-label">Unpaid bills</div>
      <div class="metric-value" style="font-size:18px">{{ $unpaidCount }}</div>
    </div>
  </div>

  <table>
    <thead>
      <tr>
        <th style="width:12%">Bill no.</th>
        <th style="width:20%">Patient</th>
        <th style="width:11%">Ward</th>
        <th style="width:13%">Amount</th>
        <th style="width:12%">Due date</th>
        <th style="width:11%">Status</th>
        <th style="width:21%">Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($bills as $bill)
      <tr>
        <td class="muted">{{ $bill->bill_no }}</td>
        <td style="font-weight:600">{{ $bill->patient_name }}</td>
        <td class="muted">{{ $bill->ward->name ?? '—' }}</td>
        <td style="font-weight:600">{{ $bill->formatted_amount }}</td>
        <td style="{{ $bill->status==='overdue' ? 'color:#A32D2D' : '' }}">
          {{ $bill->due_date?->format('M d, Y') ?? 'TBD' }}
        </td>
        <td>{!! $bill->status_badge !!}</td>
        <td>
          <div style="display:flex;gap:4px;flex-wrap:wrap">
            <form method="POST" action="{{ route('bills.pay', $bill) }}" style="margin:0">
              @csrf @method('PATCH')
              <button type="submit" class="mpbtn">Mark paid</button>
            </form>
            <a href="{{ route('bills.edit', $bill) }}" class="action-btn btn-edit">Edit</a>
            <form method="POST" action="{{ route('bills.destroy', $bill) }}" style="margin:0"
                  onsubmit="return confirm('Delete {{ $bill->bill_no }}?')">
              @csrf @method('DELETE')
              <button type="submit" class="action-btn btn-delete">Delete</button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="7" style="padding:30px 0;text-align:center;color:#94A3B8">
          No outstanding bills — all caught up! 🎉
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
