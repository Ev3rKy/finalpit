<?php $__env->startSection('page-title', 'Revenue Report'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
  <div class="card-top">
    <div class="card-title">Revenue report</div>
    <span class="badge b-blue"><?php echo e(now()->format('F Y')); ?></span>
  </div>

  <?php $__currentLoopData = $buckets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <?php $pct = $maxVal > 0 ? round(($total / $maxVal) * 100) : 0; ?>
  <div style="margin-bottom:12px">
    <div style="display:flex;justify-content:space-between;margin-bottom:3px">
      <span class="muted"><?php echo e($label); ?></span>
      <span style="font-weight:600">₱<?php echo e(number_format($total)); ?></span>
    </div>
    <div class="bar-track" style="height:10px">
      <div style="width:<?php echo e($pct); ?>%;height:100%;background:#185FA5;border-radius:4px;transition:width 0.4s"></div>
    </div>
  </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

  <div class="divider"></div>
  <div style="display:flex;justify-content:space-between;margin-bottom:5px">
    <span class="muted">Subtotal</span><span>₱<?php echo e(number_format($subtotal)); ?></span>
  </div>
  <div style="display:flex;justify-content:space-between;margin-bottom:5px">
    <span class="muted">Discounts (2.5%)</span>
    <span style="color:#A32D2D">-₱<?php echo e(number_format($discount)); ?></span>
  </div>
  <div style="display:flex;justify-content:space-between;font-weight:600">
    <span class="muted">Net revenue</span>
    <span style="color:#185FA5">₱<?php echo e(number_format($net)); ?></span>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\crest\wellmeadows-billing\resources\views/reports/revenue.blade.php ENDPATH**/ ?>