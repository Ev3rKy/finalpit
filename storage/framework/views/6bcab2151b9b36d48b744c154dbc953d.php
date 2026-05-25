<?php $__env->startSection('page-title', 'Occupancy Rate'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
  <div class="card-top">
    <div class="card-title">Occupancy rate</div>
    <span class="badge b-blue"><?php echo e(now()->format('F Y')); ?></span>
  </div>

  <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px">
    <div class="metric" style="border-top:3px solid #185FA5">
      <div class="metric-label">Total beds</div>
      <div class="metric-value"><?php echo e($totalBeds); ?></div>
    </div>
    <div class="metric" style="border-top:3px solid #378ADD">
      <div class="metric-label">Occupied</div>
      <div class="metric-value" style="color:#185FA5"><?php echo e($occupiedBeds); ?></div>
    </div>
    <div class="metric" style="border-top:3px solid #85B7EB">
      <div class="metric-label">Available</div>
      <div class="metric-value" style="color:#3B6D11"><?php echo e($availBeds); ?></div>
    </div>
    <div class="metric" style="border-top:3px solid #1D9E75">
      <div class="metric-label">Rate</div>
      <div class="metric-value"><?php echo e($rate); ?>%</div>
    </div>
  </div>

  <div class="divider"></div>
  <div class="muted" style="margin-bottom:12px">Ward breakdown</div>

  <?php $__currentLoopData = $wards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ward): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <?php
    $pct = $ward->total_beds > 0 ? round(($ward->occupied_beds / $ward->total_beds) * 100) : 0;
    $color = $pct >= 95 ? '#E24B4A' : ($pct >= 80 ? '#185FA5' : '#85B7EB');
  ?>
  <div style="margin-bottom:9px">
    <div style="display:flex;justify-content:space-between;margin-bottom:3px">
      <span class="muted"><?php echo e($ward->name); ?></span>
      <span style="font-weight:600;color:<?php echo e($color); ?>">
        <?php echo e($ward->occupied_beds); ?>/<?php echo e($ward->total_beds); ?> — <?php echo e($pct); ?>%
      </span>
    </div>
    <div class="bar-track" style="height:6px">
      <div style="width:<?php echo e($pct); ?>%;height:100%;background:<?php echo e($color); ?>;border-radius:4px"></div>
    </div>
  </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\crest\wellmeadows-billing\resources\views/reports/occupancy.blade.php ENDPATH**/ ?>