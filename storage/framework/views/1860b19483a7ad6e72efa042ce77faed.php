<?php $__env->startSection('page-title', 'Summaries'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
  <div class="card-top">
    <div class="card-title">Hospital management summary</div>
    <span class="badge b-blue"><?php echo e(now()->format('F Y')); ?></span>
  </div>

  <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px">
    <div class="metric" style="border-top:3px solid #185FA5">
      <div class="metric-label">Total patients billed</div>
      <div class="metric-value"><?php echo e($totalPatients); ?></div>
      <div class="metric-note muted">This period</div>
    </div>
    <div class="metric" style="border-top:3px solid #378ADD">
      <div class="metric-label">Revenue collected</div>
      <div class="metric-value">₱<?php echo e(number_format($collected / 1000, 1)); ?>k</div>
      <div class="metric-note" style="color:#3B6D11">Paid bills only</div>
    </div>
    <div class="metric" style="border-top:3px solid #85B7EB">
      <div class="metric-label">Avg bill amount</div>
      <div class="metric-value">₱<?php echo e(number_format($avgBill / 1000, 1)); ?>k</div>
      <div class="metric-note muted">Per patient</div>
    </div>
    <div class="metric" style="border-top:3px solid #1D9E75">
      <div class="metric-label">Collection rate</div>
      <div class="metric-value"><?php echo e($collectionRate); ?>%</div>
      <div class="metric-note" style="<?php echo e($collectionRate >= 90 ? 'color:#3B6D11' : 'color:#A32D2D'); ?>">
        <?php echo e($collectionRate >= 90 ? 'Above target' : 'Below target'); ?>

      </div>
    </div>
  </div>

  <div class="divider"></div>
  <div class="muted" style="margin-bottom:10px">Key notes</div>

  <?php $__currentLoopData = $wards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ward): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($ward->occupied_beds >= $ward->total_beds): ?>
    <div class="note-line">
      <div class="note-bar" style="background:#185FA5"></div>
      <span><?php echo e($ward->name); ?> is fully occupied — consider patient transfers to other wards.</span>
    </div>
    <?php endif; ?>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

  <?php if($unpaidCount > 0): ?>
  <div class="note-line">
    <div class="note-bar" style="background:#E24B4A"></div>
    <span><?php echo e($unpaidCount); ?> bills remain unpaid totaling ₱<?php echo e(number_format($outstandingAmt)); ?> in outstanding balance.</span>
  </div>
  <?php endif; ?>

  <div class="note-line">
    <div class="note-bar" style="background:#1D9E75"></div>
    <span>Collection rate is <?php echo e($collectionRate); ?>% — <?php echo e($collectionRate >= 90 ? 'above the 90% target.' : 'below the 90% target. Follow up on outstanding bills.'); ?></span>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\crest\wellmeadows-billing\resources\views/reports/summaries.blade.php ENDPATH**/ ?>