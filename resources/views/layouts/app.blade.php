<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wellmeadows Hospital</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
 
        :root {
            --navy:    #1e2a4a;
            --navy-light: #2c3e6b;
            --cream:   #f0ece3;
            --beige:   #e8dfc8;
            --gold:    #c9a84c;
            --text:    #1e2a4a;
            --muted:   #6b7280;
            --white:   #ffffff;
            --sidebar: 250px;
            --header:  56px;
        }
 
        body {
            font-family: 'Jost', sans-serif;
            background: var(--cream);
            color: var(--text);
            min-height: 100vh;
        }
 
        /* TOP HEADER */
        .top-header {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: var(--header);
            background: var(--navy);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            z-index: 100;
        }
        .top-header .brand {
            font-family: 'Cinzel', serif;
            color: var(--white);
            font-size: 1.15rem;
            font-weight: 600;
            letter-spacing: 0.03em;
        }
        .top-header .datetime {
            color: rgba(255,255,255,0.85);
            font-size: 0.78rem;
            letter-spacing: 0.08em;
            font-weight: 400;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .top-header .datetime .sep {
            opacity: 0.4;
        }
 
        /* SIDEBAR */
        .sidebar {
            position: fixed;
            top: var(--header);
            left: 0;
            width: var(--sidebar);
            height: calc(100vh - var(--header));
            background: var(--navy);
            display: flex;
            flex-direction: column;
            padding: 32px 0;
            z-index: 99;
        }
        .sidebar nav {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 2px;
            padding: 0 16px;
        }
        .sidebar nav a {
            display: block;
            padding: 11px 16px;
            color: rgba(255,255,255,0.55);
            text-decoration: none;
            font-size: 0.72rem;
            letter-spacing: 0.12em;
            font-weight: 500;
            text-transform: uppercase;
            border-radius: 6px;
            transition: all 0.2s;
        }
        .sidebar nav a:hover,
        .sidebar nav a.active {
            background: rgba(255,255,255,0.12);
            color: var(--white);
        }
        .sidebar .logout-area {
            padding: 0 16px;
        }
        .sidebar .logout-area form button {
            width: 100%;
            padding: 11px 16px;
            background: none;
            border: none;
            cursor: pointer;
            color: rgba(255,255,255,0.45);
            font-size: 0.72rem;
            letter-spacing: 0.12em;
            font-weight: 500;
            text-transform: uppercase;
            text-align: left;
            border-radius: 6px;
            transition: all 0.2s;
            font-family: 'Jost', sans-serif;
        }
        .sidebar .logout-area form button:hover {
            background: rgba(255,255,255,0.08);
            color: var(--white);
        }
 
        /* MAIN CONTENT */
        .main-content {
            margin-left: var(--sidebar);
            margin-top: var(--header);
            min-height: calc(100vh - var(--header));
            padding: 40px 36px;
            background: var(--cream);
        }
 
        /* CARDS */
        .card {
            background: var(--white);
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 1px 4px rgba(30,42,74,0.06);
        }
        .card-title {
            font-family: 'Cinzel', serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--navy);
            letter-spacing: 0.04em;
            margin-bottom: 24px;
        }
 
        /* FORM INPUTS */
        .form-group { margin-bottom: 16px; }
        .form-label {
            display: block;
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--navy);
            margin-bottom: 6px;
        }
        .form-input, .form-select {
            width: 100%;
            padding: 8px 12px;
            border: 1.5px solid #ddd6c8;
            border-radius: 6px;
            font-family: 'Jost', sans-serif;
            font-size: 0.85rem;
            color: var(--text);
            background: var(--white);
            outline: none;
            transition: border-color 0.2s;
            appearance: none;
        }
        .form-input:focus, .form-select:focus {
            border-color: var(--navy);
        }
        .form-select-wrap {
            position: relative;
        }
        .form-select-wrap::after {
            content: '◀';
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%) rotate(-90deg);
            font-size: 0.6rem;
            color: var(--navy);
            pointer-events: none;
        }
        .form-row {
            display: grid;
            gap: 14px;
        }
        .form-row-2 { grid-template-columns: 1fr 1fr; }
        .form-row-3 { grid-template-columns: 1fr 1fr 1fr; }
 
        /* BUTTONS */
        .btn-primary {
            background: var(--navy);
            color: var(--white);
            border: none;
            padding: 10px 28px;
            border-radius: 8px;
            font-family: 'Jost', sans-serif;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-primary:hover { background: var(--navy-light); }
 
        /* SCHEDULE LIST ITEMS */
        .schedule-item {
            background: var(--beige);
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 10px;
            font-size: 0.78rem;
            font-weight: 500;
            color: var(--navy);
            line-height: 1.5;
            letter-spacing: 0.02em;
        }
 
        /* ALERTS */
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            padding: 10px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 0.82rem;
            font-weight: 500;
        }
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 10px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 0.82rem;
        }
 
        /* STAFF AVAILABILITY LIST */
        .staff-item {
            background: var(--beige);
            border-radius: 8px;
            padding: 13px 16px;
            margin-bottom: 8px;
            font-size: 0.78rem;
            color: var(--navy);
        }
        .staff-item strong { font-weight: 700; }
        .staff-item span   { font-weight: 400; color: var(--muted); }
 
        /* TASK ITEM */
        .task-item {
            background: var(--beige);
            border-radius: 8px;
            padding: 12px 14px;
            margin-bottom: 8px;
            font-size: 0.78rem;
            font-weight: 500;
            color: var(--navy);
            display: flex;
            align-items: center;
            gap: 12px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        .task-item.done {
            background: var(--navy);
            color: var(--white);
        }
        .task-item .task-checkbox {
            width: 22px; height: 22px;
            border: 2px solid var(--navy);
            border-radius: 4px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
            background: var(--white);
        }
        .task-item.done .task-checkbox {
            background: var(--navy-light);
            border-color: var(--white);
        }
        .task-item .task-text { flex: 1; }
 
        /* SEARCH */
        .search-input {
            width: 100%;
            padding: 7px 12px;
            border: 1.5px solid #ddd6c8;
            border-radius: 6px;
            font-family: 'Jost', sans-serif;
            font-size: 0.8rem;
            color: var(--text);
            background: var(--cream);
            outline: none;
            margin-bottom: 12px;
        }
 
        /* TABLE */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.78rem;
        }
        .data-table thead th {
            background: var(--navy);
            color: var(--white);
            padding: 12px 10px;
            text-align: center;
            font-size: 0.7rem;
            letter-spacing: 0.08em;
            font-weight: 600;
            text-transform: uppercase;
        }
        .data-table tbody tr:nth-child(odd)  { background: var(--beige); }
        .data-table tbody tr:nth-child(even) { background: var(--white); }
        .data-table tbody td {
            padding: 12px 10px;
            text-align: center;
            color: var(--navy);
            font-size: 0.78rem;
            vertical-align: middle;
        }
 
        /* CALENDAR */
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0;
        }
        .cal-header {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            color: var(--navy);
            text-align: center;
            padding: 16px 0 12px;
        }
        .cal-day {
            text-align: center;
            padding: 18px 0;
            font-size: 0.9rem;
            color: var(--navy);
            cursor: default;
            border-radius: 50%;
            width: 42px;
            height: 42px;
            display: flex; align-items: center; justify-content: center;
            margin: 4px auto;
        }
        .cal-day.today {
            background: var(--beige);
            border-radius: 50%;
            font-weight: 700;
        }
 
        /* MONTH/YEAR NAV */
        .cal-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }
        .cal-title {
            font-family: 'Cinzel', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--navy);
        }
        .cal-nav-btn {
            background: var(--navy);
            color: var(--white);
            border: none;
            width: 36px; height: 36px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.9rem;
            display: flex; align-items: center; justify-content: center;
        }
 
        /* RICH TEXT TOOLBAR */
        .rte-toolbar {
            background: var(--navy);
            padding: 8px 12px;
            border-radius: 6px 6px 0 0;
            display: flex;
            gap: 8px;
        }
        .rte-btn {
            background: none;
            border: none;
            color: var(--white);
            font-weight: bold;
            cursor: pointer;
            font-size: 0.85rem;
            padding: 2px 6px;
            border-radius: 3px;
        }
        .rte-btn:hover { background: rgba(255,255,255,0.15); }
        .rte-area {
            border: 1.5px solid #ddd6c8;
            border-top: none;
            border-radius: 0 0 6px 6px;
            min-height: 280px;
            padding: 12px;
            font-family: 'Jost', sans-serif;
            font-size: 0.85rem;
            outline: none;
        }
    </style>
</head>
<body>
 
{{-- TOP HEADER --}}
<header class="top-header">
    <span class="brand">Wellmeadows Hospital</span>
    <div class="datetime">
        <span id="live-date"></span>
        <span class="sep">|</span>
        <span id="live-time"></span>
    </div>
</header>
 
{{-- SIDEBAR --}}
<aside class="sidebar">
    <nav>
        <a href="{{ route('dashboard') }}"       class="{{ request()->routeIs('dashboard')       ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('appointment') }}"     class="{{ request()->routeIs('appointment')     ? 'active' : '' }}">Appointment</a>
        <a href="{{ route('medical-record') }}"  class="{{ request()->routeIs('medical-record')  ? 'active' : '' }}">Medical Record</a>
        <a href="{{ route('treatment-history') }}" class="{{ request()->routeIs('treatment-history') ? 'active' : '' }}">Treatment History</a>
        <a href="{{ route('assign-staff') }}"    class="{{ request()->routeIs('assign-staff')    ? 'active' : '' }}">Assign Doctors &amp; Nurses</a>
    </nav>
    <div class="logout-area">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Log Out</button>
        </form>
    </div>
</aside>
 
{{-- MAIN --}}
<main class="main-content">
    @yield('content')
</main>
 
<script>
function updateClock() {
    const now = new Date();
    const dateOpts = { month: 'short', day: 'numeric', year: 'numeric' };
    const timeOpts = { hour: '2-digit', minute: '2-digit', hour12: true };
    document.getElementById('live-date').textContent =
        now.toLocaleDateString('en-US', dateOpts).toUpperCase();
    document.getElementById('live-time').textContent =
        now.toLocaleTimeString('en-US', timeOpts);
}
updateClock();
setInterval(updateClock, 1000);
</script>
 
@stack('scripts')
</body>
</html>
