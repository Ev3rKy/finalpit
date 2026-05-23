@extends('layouts.staff')

@section('title', 'Ward Allocation — Wellmeadows')
@section('top_title', 'Ward Allocation')
@section('top_sub', 'WEEKLY SHIFT SCHEDULE')

@section('content')
<div class="sh">
    <div>
        <div class="sh-title">Ward Allocation</div>
        <div class="sh-sub">Weekly shift schedule by ward</div>
    </div>
    <button class="btn b-nv" type="button" onclick="toggleForm('addForm')">+ Assign Staff</button>
</div>

<div class="filters">
    <select class="fsel" id="wardFilter">
        <option value="">All Wards</option>
        @foreach($wards as $ward)
        <option value="{{ $ward->ward_number }}">Ward {{ $ward->ward_number }} – {{ $ward->ward_name }}</option>
        @endforeach
    </select>
    <select class="fsel" id="weekFilter">
        <option value="">All Weeks</option>
        @foreach($weeks as $week)
        <option value="{{ $week }}">Week: {{ \Carbon\Carbon::parse($week)->format('d M Y') }}</option>
        @endforeach
    </select>
    <select class="fsel" id="shiftFilter">
        <option value="">All Shifts</option>
        <option value="Early">Early</option>
        <option value="Late">Late</option>
        <option value="Night">Night</option>
    </select>
</div>

@if($selectedWard)
<div class="ward-info" id="wardInfoBanner">
    <div>
        <div class="wi-title">Ward {{ $selectedWard->ward_number }} — {{ $selectedWard->ward_name }}</div>
        <div class="wi-sub">
            {{ $selectedWard->location ?? 'Hospital' }}
            @if($selectedWard->tel_extn) · Tel Ext: {{ $selectedWard->tel_extn }} @endif
        </div>
    </div>
    <div class="wi-stats">
        <div class="wi-stat">
            <div class="wi-stat-n" id="statEarly">{{ $allocations->where('shift','Early')->count() }}</div>
            <div class="wi-stat-l">Early</div>
        </div>
        <div class="wi-stat">
            <div class="wi-stat-n" id="statLate">{{ $allocations->where('shift','Late')->count() }}</div>
            <div class="wi-stat-l">Late</div>
        </div>
        <div class="wi-stat">
            <div class="wi-stat-n" id="statNight">{{ $allocations->where('shift','Night')->count() }}</div>
            <div class="wi-stat-l">Night</div>
        </div>
        <div class="wi-stat">
            <div class="wi-stat-n" id="statTotal">{{ $allocations->count() }}</div>
            <div class="wi-stat-l">Total</div>
        </div>
    </div>
</div>
@endif

<div class="shift-grid">
    @foreach(['Early' => 'ea', 'Late' => 'lt', 'Night' => 'nt'] as $shiftName => $shiftClass)
    <div class="scard shift-card" data-shift="{{ $shiftName }}">
        <div class="shd {{ $shiftClass }}">
            <div class="sl">
                @if($shiftName === 'Early') 🌅 Early Shift
                @elseif($shiftName === 'Late') 🌤 Late Shift
                @else 🌙 Night Shift
                @endif
            </div>
            <div class="st">
                @if($shiftName === 'Early') 06:00 – 14:00
                @elseif($shiftName === 'Late') 14:00 – 22:00
                @else 22:00 – 06:00
                @endif
            </div>
        </div>
        <div class="sbody" id="shiftBody{{ $shiftName }}">
            @php $shiftItems = $allocations->where('shift', $shiftName); @endphp
            @forelse($shiftItems as $a)
            <div class="sp alloc-item"
                 data-ward="{{ $a->ward_number }}"
                 data-week="{{ $a->week_start_date }}"
                 data-shift="{{ $a->shift }}">
                <div class="spav">{{ strtoupper(substr($a->staff->first_name,0,1).substr($a->staff->last_name,0,1)) }}</div>
                <div>
                    <div class="spn">{{ $a->staff->first_name }} {{ $a->staff->last_name }}</div>
                    <div class="spp">{{ $a->staff->position }}</div>
                </div>
            </div>
            @empty
            <div class="sempty alloc-empty">No staff assigned</div>
            @endforelse
        </div>
    </div>
    @endforeach
</div>

<div class="card">
    <div class="card-hd">
        <div>
            <div class="card-title">Full Allocation Table</div>
            <div class="card-sub">All staff assignments for this period</div>
        </div>
    </div>

    <div class="add-form" id="addForm">
        <form action="{{ route('ward-allocation.store') }}" method="POST">
            @csrf
            <div class="fg-inline">
                <div class="fgp">
                    <label>Staff Member *</label>
                    <select name="staff_number" required>
                        <option value="">-- Select Staff --</option>
                        @foreach($staffList as $s)
                        <option value="{{ $s->staff_number }}">{{ $s->first_name }} {{ $s->last_name }} ({{ $s->position }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="fgp">
                    <label>Ward *</label>
                    <select name="ward_number" required>
                        <option value="">-- Select Ward --</option>
                        @foreach($wards as $w)
                        <option value="{{ $w->ward_number }}">Ward {{ $w->ward_number }} – {{ $w->ward_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="fgp">
                    <label>Week Start Date *</label>
                    <input type="date" name="week_start_date" required>
                </div>
                <div class="fgp">
                    <label>Shift *</label>
                    <select name="shift" required>
                        <option value="">-- Select --</option>
                        <option value="Early">Early (06:00-14:00)</option>
                        <option value="Late">Late (14:00-22:00)</option>
                        <option value="Night">Night (22:00-06:00)</option>
                    </select>
                </div>
                <div style="display:flex;gap:6px;align-items:flex-end;padding-bottom:1px">
                    <button type="submit" class="btn b-nv b-sm">Assign</button>
                    <button type="button" class="btn b-ol b-sm" onclick="toggleForm('addForm')">Cancel</button>
                </div>
            </div>
        </form>
    </div>

    <table class="tbl" id="allocationTable">
        <thead>
            <tr>
                <th>Staff</th>
                <th>Staff No.</th>
                <th>Position</th>
                <th>Ward</th>
                <th>Week Start</th>
                <th>Shift</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($allocations as $a)
            <tr class="alloc-row"
                data-ward="{{ $a->ward_number }}"
                data-week="{{ $a->week_start_date }}"
                data-shift="{{ $a->shift }}">
                <td>
                    <div class="p-info">
                        <div class="p-av">{{ strtoupper(substr($a->staff->first_name,0,1).substr($a->staff->last_name,0,1)) }}</div>
                        <strong>{{ $a->staff->first_name }} {{ $a->staff->last_name }}</strong>
                    </div>
                </td>
                <td class="mono">{{ $a->staff_number }}</td>
                <td><span class="bdg br">{{ $a->staff->position }}</span></td>
                <td>Ward {{ $a->ward_number }}</td>
                <td>{{ \Carbon\Carbon::parse($a->week_start_date)->format('d M Y') }}</td>
                <td>
                    <span class="bdg {{ $a->shift=='Early'?'be':($a->shift=='Late'?'bl':'bn') }}">
                        {{ $a->shift }}
                    </span>
                </td>
                <td>
                    <form action="{{ route('ward-allocation.destroy', $a->allocation_id) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn b-dn b-sm" onclick="return confirm('Remove this assignment?')">Remove</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr id="noAllocRow">
                <td colspan="7" style="text-align:center;padding:40px;color:var(--muted)">
                    No staff assigned yet.
                    <button type="button" class="btn b-nv b-sm" onclick="toggleForm('addForm')" style="margin-left:8px">+ Assign Staff</button>
                </td>
            </tr>
            @endforelse
            <tr id="noAllocFilterRow" style="display:none">
                <td colspan="7" style="text-align:center;padding:40px;color:var(--muted)">
                    No assignments match the selected filters.
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
function toggleForm(id) {
    document.getElementById(id).classList.toggle('show');
}

(function () {
    const wardFilter = document.getElementById('wardFilter');
    const weekFilter = document.getElementById('weekFilter');
    const shiftFilter = document.getElementById('shiftFilter');
    const rows = Array.from(document.querySelectorAll('.alloc-row'));
    const items = Array.from(document.querySelectorAll('.alloc-item'));
    const noFilterRow = document.getElementById('noAllocFilterRow');

    function updateStats() {
        const visible = rows.filter(r => r.style.display !== 'none');
        const count = (shift) => visible.filter(r => r.dataset.shift === shift).length;
        const stat = (id, n) => { const el = document.getElementById(id); if (el) el.textContent = n; };
        stat('statEarly', count('Early'));
        stat('statLate', count('Late'));
        stat('statNight', count('Night'));
        stat('statTotal', visible.length);
    }

    function filterAllocations() {
        const ward = wardFilter?.value || '';
        const week = weekFilter?.value || '';
        const shift = shiftFilter?.value || '';
        let visibleRows = 0;

        rows.forEach(row => {
            const show = (!ward || row.dataset.ward === ward)
                && (!week || row.dataset.week === week)
                && (!shift || row.dataset.shift === shift);
            row.style.display = show ? '' : 'none';
            if (show) visibleRows++;
        });

        items.forEach(item => {
            const show = (!ward || item.dataset.ward === ward)
                && (!week || item.dataset.week === week)
                && (!shift || item.dataset.shift === shift);
            item.style.display = show ? '' : 'none';
        });

        document.querySelectorAll('.shift-card').forEach(card => {
            const shiftName = card.dataset.shift;
            const body = card.querySelector('.sbody');
            const visibleInShift = items.filter(i =>
                i.dataset.shift === shiftName && i.style.display !== 'none'
            );
            const empty = body?.querySelector('.alloc-empty');
            if (empty) empty.style.display = visibleInShift.length ? 'none' : '';
        });

        if (noFilterRow) {
            noFilterRow.style.display = rows.length && visibleRows === 0 ? '' : 'none';
        }
        updateStats();
    }

    wardFilter?.addEventListener('change', filterAllocations);
    weekFilter?.addEventListener('change', filterAllocations);
    shiftFilter?.addEventListener('change', filterAllocations);
})();
</script>
@endpush
