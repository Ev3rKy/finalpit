<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Wellmeadows Hospital — Billing & Reporting</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="app">

  {{-- SIDEBAR --}}
  <div class="sidebar">
    <div class="brand-wrap">
      <div class="brand-name">Billing &amp; Reports</div>
      <div class="brand-sub">Wellmeadows Hospital</div>
    </div>

    <div class="nav-label">Billing</div>
    <a href="{{ route('dashboard') }}"        class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"><span class="nav-dot"></span> Dashboard</a>
    <a href="{{ route('bills.create') }}"     class="nav-item {{ request()->routeIs('bills.create') ? 'active' : '' }}"><span class="nav-dot"></span> Generate bill</a>
    <a href="{{ route('bills.index') }}"      class="nav-item {{ request()->routeIs('bills.index') ? 'active' : '' }}"><span class="nav-dot"></span> Patient bills</a>
    <a href="{{ route('bills.outstanding') }}" class="nav-item {{ request()->routeIs('bills.outstanding') ? 'active' : '' }}"><span class="nav-dot"></span> Outstanding</a>
    <a href="{{ route('wards.index') }}"      class="nav-item {{ request()->routeIs('wards.*') ? 'active' : '' }}"><span class="nav-dot"></span> Wards</a>

    <div class="nav-label" style="margin-top:8px">Reports</div>
    <a href="{{ route('reports.revenue') }}"   class="nav-item {{ request()->routeIs('reports.revenue') ? 'active' : '' }}"><span class="nav-dot"></span> Revenue</a>
    <a href="{{ route('reports.occupancy') }}" class="nav-item {{ request()->routeIs('reports.occupancy') ? 'active' : '' }}"><span class="nav-dot"></span> Occupancy rate</a>
    <a href="{{ route('reports.summaries') }}" class="nav-item {{ request()->routeIs('reports.summaries') ? 'active' : '' }}"><span class="nav-dot"></span> Summaries</a>

    <div class="sidebar-footer">
      <div class="module-tag">Module 5</div>
    </div>
  </div>

  {{-- MAIN --}}
  <div class="main">
    <div class="topbar">
      <div>
        <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
        <div class="topbar-sub">Wellmeadows Hospital · {{ now()->format('F Y') }}</div>
      </div>
    <div class="topbar-actions">
        <a href="{{ route('bills.create') }}" class="btn btn-primary">+ New bill</a>
      </div>
    </div>

    <div class="content">

      {{-- Flash success --}}
      @if(session('success'))
        <div class="toast toast-success" id="flash-toast">✓ {{ session('success') }}</div>
      @endif

      {{-- Flash error --}}
      @if(session('error'))
        <div class="toast toast-error" id="flash-toast">✕ {{ session('error') }}</div>
      @endif

      {{-- Validation errors --}}
      @if($errors->any())
        <div class="toast toast-error">✕ {{ $errors->first() }}</div>
      @endif

      @yield('content')
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const t = document.getElementById('flash-toast');
    if (t) {
      t.style.display = 'block';
      setTimeout(() => { t.style.opacity='0'; t.style.transition='opacity 0.5s'; setTimeout(()=>t.style.display='none',500); }, 4000);
    }
  });
</script>
</body>
</html>
