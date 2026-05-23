@extends('layouts.app')
 
@section('content')
<div class="card" style="max-width: 900px; margin: 0 auto;">
    <div class="cal-nav">
        <div class="cal-title" id="cal-month-year">MAY 2026</div>
        <button class="cal-nav-btn" onclick="changeMonth(1)" style="font-size:1rem;">&#9650;&#9660;</button>
    </div>
 
    <div class="calendar-grid">
        @foreach(['MON','TUE','WED','THU','FRI','SAT','SUN'] as $day)
            <div class="cal-header">{{ $day }}</div>
        @endforeach
        <div id="cal-days" style="display:contents;"></div>
    </div>
</div>
@endsection
 
@push('scripts')
<script>
    let currentDate = new Date();
    let viewYear  = currentDate.getFullYear();
    let viewMonth = currentDate.getMonth(); // 0-indexed
 
    const monthNames = ['JANUARY','FEBRUARY','MARCH','APRIL','MAY','JUNE',
                        'JULY','AUGUST','SEPTEMBER','OCTOBER','NOVEMBER','DECEMBER'];
 
    function renderCalendar() {
        document.getElementById('cal-month-year').textContent =
            monthNames[viewMonth] + ' ' + viewYear;
 
        const firstDay = new Date(viewYear, viewMonth, 1).getDay(); // 0=Sun
        // Convert to Mon=0 Sun=6
        const startOffset = (firstDay === 0) ? 6 : firstDay - 1;
        const daysInMonth = new Date(viewYear, viewMonth + 1, 0).getDate();
 
        const today = new Date();
        let html = '';
 
        // Empty cells before first day
        for (let i = 0; i < startOffset; i++) {
            html += '<div></div>';
        }
 
        for (let d = 1; d <= daysInMonth; d++) {
            const isToday = (d === today.getDate() && viewMonth === today.getMonth() && viewYear === today.getFullYear());
            html += `<div class="cal-day ${isToday ? 'today' : ''}">${d}</div>`;
        }
 
        document.getElementById('cal-days').innerHTML = html;
    }
 
    // Toggle between months (simple nav: clicking icon cycles)
    let navDir = 1;
    function changeMonth(dir) {
        viewMonth += navDir;
        if (viewMonth > 11) { viewMonth = 0; viewYear++; }
        if (viewMonth < 0)  { viewMonth = 11; viewYear--; }
        navDir *= -1;
        renderCalendar();
    }
 
    renderCalendar();
</script>
@endpush
