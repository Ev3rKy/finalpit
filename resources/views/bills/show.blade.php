@extends('layouts.app')
@section('page-title', 'Bill Details')

@section('content')
<div class="card" style="max-width:600px">
  <div class="card-top">
    <div>
      <div class="card-title">{{ $bill->bill_no }}</div>
      <div class="muted" style="font-size:11px;margin-top:2px">Generated {{ $bill->created_at->format('F d, Y') }}</div>
    </div>
    {!! $bill->status_badge !!}
  </div>

  <div class="detail-grid">
    <div class="detail-row">
      <span class="detail-label">Patient name</span>
      <span class="detail-value">{{ $bill->patient_name }}</span>
    </div>
    <div class="detail-row">
      <span class="detail-label">Patient ID</span>
      <span class="detail-value">{{ $bill->patient_id }}</span>
    </div>
    <div class="detail-row">
      <span class="detail-label">Ward</span>
      <span class="detail-value">{{ $bill->ward->name ?? '—' }}</span>
    </div>
    <div class="detail-row">
      <span class="detail-label">Service</span>
      <span class="detail-value">{{ $bill->service }}</span>
    </div>
    <div class="detail-row">
      <span class="detail-label">Amount</span>
      <span class="detail-value" style="font-size:16px;font-weight:700;color:#185FA5">{{ $bill->formatted_amount }}</span>
    </div>
    <div class="detail-row">
      <span class="detail-label">Due date</span>
      <span class="detail-value {{ $bill->status==='overdue'?'text-red':'' }}">
        {{ $bill->due_date?->format('F d, Y') ?? 'Not set' }}
      </span>
    </div>
    @if($bill->paid_at)
    <div class="detail-row">
      <span class="detail-label">Paid on</span>
      <span class="detail-value" style="color:#27500A">{{ $bill->paid_at->format('F d, Y h:i A') }}</span>
    </div>
    @endif
  </div>

  <div class="divider"></div>

  <div style="display:flex;gap:8px;flex-wrap:wrap">
    <a href="{{ route('bills.edit', $bill) }}" class="btn btn-primary">Edit bill</a>

    @if($bill->status !== 'paid')
    <form method="POST" action="{{ route('bills.pay', $bill) }}" style="margin:0">
      @csrf @method('PATCH')
      <button type="submit" class="btn" style="background:#EAF3DE;color:#27500A;border-color:#3B6D11">
        ✓ Mark as paid
      </button>
    </form>
    @endif

    <form method="POST" action="{{ route('bills.destroy', $bill) }}" style="margin:0"
          onsubmit="return confirm('Delete {{ $bill->bill_no }}? This cannot be undone.')">
      @csrf @method('DELETE')
      <button type="submit" class="btn" style="background:#FCEBEB;color:#791F1F;border-color:#E24B4A">
        Delete bill
      </button>
    </form>

    <a href="{{ route('bills.index') }}" class="btn">← Back to bills</a>
  </div>
</div>
@endsection
