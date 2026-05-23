@extends('layouts.app')

@section('content')
<div style="display:grid; grid-template-columns:1fr 1.6fr; gap:24px; max-width:1100px; margin:0 auto; align-items:start;">

    {{-- LEFT COLUMN --}}
    <div style="display:flex; flex-direction:column; gap:20px;">

        {{-- STAFF ASSIGNMENT FORM --}}
        <div class="card">
            <div class="card-title">Staff Assignment</div>

            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert-error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('assign-staff.store') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Patient Full Name</label>
                    <input class="form-input" type="text" name="patient_full_name" value="{{ old('patient_full_name') }}" required>
                </div>
                <div class="form-row form-row-2" style="margin-bottom:20px;">
                    <div>
                        <label class="form-label">Treatment Type</label>
                        <input class="form-input" type="text" name="treatment_type" value="{{ old('treatment_type') }}" required placeholder="e.g. Surgery">
                    </div>
                    <div>
                        <label class="form-label">Assign Nr./Dr.</label>
                        <input class="form-input" type="text" name="assigned_staff" id="assigned_staff_input" value="{{ old('assigned_staff') }}" required placeholder="Click a name →">
                    </div>
                </div>
                <div style="text-align:center;">
                    <button class="btn-primary" type="submit">Add Task</button>
                </div>
            </form>
        </div>

        {{-- STAFF TASK LIST --}}
        <div class="card">
            <div class="card-title">Staff Task</div>
            @forelse($tasks as $task)
                <form method="POST" action="{{ route('assign-staff.toggle', $task->id) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                        class="task-item"
                        style="width:100%; text-align:left; border:none; cursor:pointer;"
                        onclick="return confirm('Mark this task as done? The staff will return to availability.')">
                        <div class="task-checkbox"></div>
                        <div class="task-text">
                            {{ strtoupper($task->assigned_staff) }} TO {{ strtoupper($task->patient_full_name) }} FOR {{ strtoupper($task->treatment_type) }}
                        </div>
                    </button>
                </form>
            @empty
                <p style="font-size:0.8rem; color:#999; text-align:center; padding:16px 0;">No tasks assigned yet.</p>
            @endforelse
        </div>

    </div>

    {{-- RIGHT COLUMN — STAFF AVAILABILITY --}}
    <div class="card">
        <div class="card-title">Staff Availability</div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">

            {{-- DOCTORS --}}
            <div>
                <div class="form-label" style="margin-bottom:10px;">Doctors</div>
                <input class="search-input" type="text" placeholder="SEARCH" oninput="filterList('doc-list', this.value)">
                <div id="doc-list">
                    @forelse($doctors as $doc)
                        <div class="staff-item" onclick="selectStaff('{{ $doc->full_name }}')" style="cursor:pointer;">
                            <strong>{{ strtoupper($doc->full_name) }}</strong><br>
                            <span>{{ strtoupper($doc->specialty ?? '') }}</span>
                        </div>
                    @empty
                        <p style="font-size:0.78rem; color:#999;">All doctors assigned.</p>
                    @endforelse
                </div>
            </div>

            {{-- NURSES --}}
            <div>
                <div class="form-label" style="margin-bottom:10px;">Nurses</div>
                <input class="search-input" type="text" placeholder="SEARCH" oninput="filterList('nur-list', this.value)">
                <div id="nur-list">
                    @forelse($nurses as $nur)
                        <div class="staff-item" onclick="selectStaff('{{ $nur->full_name }}')" style="cursor:pointer;">
                            <strong>{{ strtoupper($nur->full_name) }}</strong><br>
                            <span>{{ strtoupper($nur->specialty ?? '') }}</span>
                        </div>
                    @empty
                        <p style="font-size:0.78rem; color:#999;">All nurses assigned.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
function selectStaff(name) {
    document.getElementById('assigned_staff_input').value = name;
}
function filterList(listId, query) {
    const items = document.querySelectorAll('#' + listId + ' .staff-item');
    query = query.toLowerCase();
    items.forEach(item => {
        item.style.display = item.textContent.toLowerCase().includes(query) ? '' : 'none';
    });
}
</script>
@endpush
