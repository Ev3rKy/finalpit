<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wellmeadows Hospital</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f5f0e8; display: flex; }

        /* Sidebar */
        .sidebar {
            width: 200px;
            background: #1a1f5e;
            min-height: 100vh;
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            padding: 24px 0;
            z-index: 100;
        }
        .sidebar-logo {
            color: white;
            font-size: 18px;
            font-weight: 800;
            padding: 0 20px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 16px;
        }
        .sidebar-logo span { color: #2dd4c0; }
        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        .nav-item:hover, .nav-item.active {
            color: white;
            background: rgba(255,255,255,0.08);
            border-left-color: #2dd4c0;
        }
        .nav-item svg { width: 16px; height: 16px; flex-shrink: 0; }
        .nav-section {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2px;
            color: rgba(255,255,255,0.3);
            padding: 16px 20px 6px;
            text-transform: uppercase;
        }
        .sidebar-footer {
            margin-top: auto;
            padding: 16px 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.4);
            font-size: 11px;
        }

        /* Main */
        .main { margin-left: 200px; flex: 1; min-height: 100vh; }
        .topbar {
            background: #1a1f5e;
            color: white;
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .topbar h2 { font-size: 13px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; }
        .topbar-actions { display: flex; gap: 10px; align-items: center; }
        .topbar-date { font-size: 12px; opacity: 0.6; margin-right: 12px; }

        /* Buttons */
        .btn {
            padding: 8px 18px; border-radius: 6px; border: none;
            cursor: pointer; font-size: 12px; font-weight: 600;
            text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-teal { background: #2dd4c0; color: white; }
        .btn-teal:hover { background: #20b2a0; }
        .btn-navy { background: #1a1f5e; color: white; }
        .btn-blue { background: #3b5bdb; color: white; }
        .btn-blue:hover { background: #2f4bc4; }
        .btn-red { background: #e03131; color: white; }
        .btn-outline { background: transparent; border: 1px solid rgba(255,255,255,0.4); color: white; }
        .btn-outline:hover { background: rgba(255,255,255,0.1); }
        .btn-sm { padding: 5px 12px; font-size: 11px; }

        /* Content */
        .content { padding: 28px 32px; }

        /* Modal */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.active { display: flex; }
        .modal {
            background: white;
            border-radius: 16px;
            padding: 32px;
            width: 700px;
            max-width: 95vw;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
        .modal-header h3 { font-size: 16px; font-weight: 700; color: #1a1f5e; }
        .modal-close {
            background: none; border: none; font-size: 20px;
            cursor: pointer; color: #888; line-height: 1;
        }
        .modal-close:hover { color: #333; }

        /* Form styles */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-group { display: flex; flex-direction: column; gap: 4px; }
        .form-group.full { grid-column: 1 / -1; }
        .form-group label { font-size: 11px; font-weight: 600; color: #888; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-group input,
        .form-group select {
            border: none;
            border-bottom: 1px solid #ddd;
            padding: 8px 0;
            font-size: 13px;
            outline: none;
            background: transparent;
            color: #333;
        }
        .form-group input:focus,
        .form-group select:focus { border-bottom-color: #2dd4c0; }
        .form-section-title {
            font-size: 11px; font-weight: 700; letter-spacing: 2px;
            color: #888; padding-bottom: 8px;
            border-bottom: 1px solid #eee; margin: 16px 0 12px;
            grid-column: 1 / -1;
            text-transform: uppercase;
        }
        .form-actions {
            display: flex; gap: 10px; margin-top: 24px;
            justify-content: flex-end;
        }

        /* Alert */
        .alert-success {
            background: #d3f9d8; color: #2b8a3e;
            padding: 10px 16px; border-radius: 8px; margin-bottom:16px;
            font-size: 13px;
        }
    </style>
</head>
<body>

{{-- Sidebar --}}
<div class="sidebar">
    <div class="sidebar-logo">Well<span>meadows</span></div>

    <div class="nav-section">Patient Management</div>
    <a href="{{ route('patients.index') }}" class="nav-item {{ request()->routeIs('patients.index') ? 'active' : '' }}">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2h5M12 12a4 4 0 100-8 4 4 0 000 8z"/></svg>
        Patient Register
    </a>
    <a href="{{ route('medical.index') }}" class="nav-item {{ request()->routeIs('medical.index') ? 'active' : '' }}">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-3-3v6M4 6h16M4 10h16M4 14h10"/></svg>
        Medical Records
    </a>  

    <a href="{{ route('ward.index') }}" class="nav-item {{ request()->routeIs('ward.index') ? 'active' : '' }}">
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
    Ward & Bed
</a>

<a href="{{ route('admission.index') }}" class="nav-item {{ request()->routeIs('admission.index') ? 'active' : '' }}">
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
    Admission & Discharge
</a>

    <div class="nav-section">System</div>
    <a href="#" class="nav-item">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>
        Settings
    </a>

    <div class="sidebar-footer">Wellmeadows v1.0</div>
</div>

{{-- Main --}}
<div class="main">
    @yield('content')
</div>

@yield('scripts')
</body>
</html>