@extends('layouts.app')
@section('page-title', 'Patient Bills')

@section('content')
<div class="card">
  <div class="card-top">
    <div class="card-title">All patient bills</div>
    <span class="badge b-blue">{{ $allCount }} total</span>
  </div>

  {{-- Search & Filter --}}
  <form method="GET" action="{{ route('bills.index') }}" style="display:flex;gap:8px;margin-bottom:14px">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Search name, bill no, patient ID…" class="search-input">
    <select name="status" class="search-select">
      <option value="">All statuses</option>
      <option value="pending" {{ request('status')==='pending' ? 'selected':'' }}>Pending</option>
      <option value="paid"    {{ request('status')==='paid'    ? 'selected':'' }}>Paid</option>
      <option value="overdue" {{ request('status')==='overdue' ? 'selected':'' }}>Overdue</option>
    </select>
    <button type="submit" class="btn btn-primary">Filter</button>
    @if(request()->hasAny(['search','status']))
      <a href="{{ route('bills.index') }}" class="btn">Clear</a>
    @endif
  </form>

  <table>
    <thead>
      <tr>
        <th style="width:11%">Bill no.</th>
        <th style="width:20%">Patient</th>
        <th style="width:9%">Ward</th>
        <th style="width:16%">Service</th>
        <th style="width:11%">Amount</th>
        <th style="width:10%">Due date</th>
        <th style="width:10%">Status</th>
        <th style="width:13%">Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($bills as $bill)
      <tr>
        <td class="muted">{{ $bill->bill_no }}</td>
        <td style="font-weight:600">{{ $bill->patient_name }}</td>
        <td class="muted">{{ $bill->ward->name ?? '—' }}</td>
        <td class="muted">{{ $bill->service }}</td>
        <td style="font-weight:600">{{ $bill->formatted_amount }}</td>
        <td class="{{ $bill->status==='overdue'?'text-red':'muted' }}">
          {{ $bill->due_date?->format('M d, Y') ?? 'TBD' }}
        </td>
        <td>{!! $bill->status_badge !!}</td>
        <td>
          <div style="display:flex;gap:4px;flex-wrap:wrap">
            <a href="{{ route('bills.show', $bill) }}" class="action-btn btn-view">View</a>
            <a href="{{ route('bills.edit', $bill) }}" class="action-btn btn-edit">Edit</a>
            <form method="POST" action="{{ route('bills.destroy', $bill) }}"
                  onsubmit="return confirm('Delete {{ $bill->bill_no }}? This cannot be undone.')">
              @csrf @method('DELETE')
              <button type="submit" class="action-btn btn-delete">Delete</button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="8" style="padding:30px 0;text-align:center;color:#94A3B8">
          No bills yet. <a href="{{ route('bills.create') }}" style="color:#185FA5">Generate the first bill →</a>
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>

  @if($bills->hasPages())
  <div style="margin-top:14px">{{ $bills->links() }}</div>
  @endif
</div>
@endsection
