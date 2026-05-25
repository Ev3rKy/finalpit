<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Wellmeadows Hospital — Billing & Reporting</title>
  <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</head>
<body>
<div class="app">

  
  <div class="sidebar">
    <div class="brand-wrap">
      <div class="brand-name">Billing &amp; Reports</div>
      <div class="brand-sub">Wellmeadows Hospital</div>
    </div>

    <div class="nav-label">Billing</div>
    <a href="<?php echo e(route('dashboard')); ?>"        class="nav-item <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>"><span class="nav-dot"></span> Dashboard</a>
    <a href="<?php echo e(route('bills.create')); ?>"     class="nav-item <?php echo e(request()->routeIs('bills.create') ? 'active' : ''); ?>"><span class="nav-dot"></span> Generate bill</a>
    <a href="<?php echo e(route('bills.index')); ?>"      class="nav-item <?php echo e(request()->routeIs('bills.index') ? 'active' : ''); ?>"><span class="nav-dot"></span> Patient bills</a>
    <a href="<?php echo e(route('bills.outstanding')); ?>" class="nav-item <?php echo e(request()->routeIs('bills.outstanding') ? 'active' : ''); ?>"><span class="nav-dot"></span> Outstanding</a>
    <a href="<?php echo e(route('wards.index')); ?>"      class="nav-item <?php echo e(request()->routeIs('wards.*') ? 'active' : ''); ?>"><span class="nav-dot"></span> Wards</a>

    <div class="nav-label" style="margin-top:8px">Reports</div>
    <a href="<?php echo e(route('reports.revenue')); ?>"   class="nav-item <?php echo e(request()->routeIs('reports.revenue') ? 'active' : ''); ?>"><span class="nav-dot"></span> Revenue</a>
    <a href="<?php echo e(route('reports.occupancy')); ?>" class="nav-item <?php echo e(request()->routeIs('reports.occupancy') ? 'active' : ''); ?>"><span class="nav-dot"></span> Occupancy rate</a>
    <a href="<?php echo e(route('reports.summaries')); ?>" class="nav-item <?php echo e(request()->routeIs('reports.summaries') ? 'active' : ''); ?>"><span class="nav-dot"></span> Summaries</a>

    <div class="sidebar-footer">
      <div class="module-tag">Module 5</div>
    </div>
  </div>

  
  <div class="main">
    <div class="topbar">
      <div>
        <div class="topbar-title"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></div>
        <div class="topbar-sub">Wellmeadows Hospital · <?php echo e(now()->format('F Y')); ?></div>
      </div>
    <div class="topbar-actions">
        <a href="<?php echo e(route('bills.create')); ?>" class="btn btn-primary">+ New bill</a>
      </div>
    </div>

    <div class="content">

      
      <?php if(session('success')): ?>
        <div class="toast toast-success" id="flash-toast">✓ <?php echo e(session('success')); ?></div>
      <?php endif; ?>

      
      <?php if(session('error')): ?>
        <div class="toast toast-error" id="flash-toast">✕ <?php echo e(session('error')); ?></div>
      <?php endif; ?>

      
      <?php if($errors->any()): ?>
        <div class="toast toast-error">✕ <?php echo e($errors->first()); ?></div>
      <?php endif; ?>

      <?php echo $__env->yieldContent('content'); ?>
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
<?php /**PATH C:\Users\crest\wellmeadows-billing\resources\views/layouts/app.blade.php ENDPATH**/ ?>