<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>


<div class="metrics">
  <div class="metric" style="border-top:3px solid #185FA5">
    <div class="metric-label">Total revenue</div>
    <div class="metric-value">
      <?php echo e($totalRevenue >= 1000 ? '₱'.number_format($totalRevenue/1000,1).'k' : '₱'.number_format($totalRevenue)); ?>

    </div>
    <div class="metric-note" style="color:#3B6D11">Paid bills only</div>
  </div>
  <div class="metric" style="border-top:3px solid #378ADD">
    <div class="metric-label">Bills generated</div>
    <div class="metric-value"><?php echo e($billCount); ?></div>
    <div class="metric-note muted"><?php echo e(now()->format('F Y')); ?></div>
  </div>
  <div class="metric" style="border-top:3px solid #E24B4A">
    <div class="metric-label">Outstanding</div>
    <div class="metric-value">
      <?php echo e($outstandingAmt >= 1000 ? '₱'.number_format($outstandingAmt/1000,1).'k' : '₱'.number_format($outstandingAmt)); ?>

    </div>
    <div class="metric-note" style="color:#A32D2D"><?php echo e($unpaidCount); ?> unpaid</div>
  </div>
  <div class="metric" style="border-top:3px solid #1D9E75">
    <div class="metric-label">Occupancy</div>
    <div class="metric-value"><?php echo e($occupancyPct); ?>%</div>
    <div class="metric-note" style="color:#3B6D11"><?php echo e($occupiedBeds); ?>/<?php echo e($totalBeds); ?> beds</div>
  </div>
</div>

<?php if($billCount === 0): ?>

<div class="card" style="text-align:center;padding:48px 24px">
  <div style="font-size:40px;margin-bottom:12px">🏥</div>
  <div style="font-weight:600;font-size:15px;margin-bottom:6px">No bills yet</div>
  <div class="muted" style="margin-bottom:20px">Generate your first bill to get started.</div>
  <a href="<?php echo e(route('bills.create')); ?>" class="btn btn-primary">+ Generate first bill</a>
</div>
<?php else: ?>

<div class="two-col">

  
  <div class="card">
    <div class="card-top">
      <div class="card-title">Recent bills</div>
      <a href="<?php echo e(route('bills.index')); ?>" class="badge b-blue" style="text-decoration:none">View all</a>
    </div>
    <?php $__empty_1 = true; $__currentLoopData = $recentBills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="bill-row">
      <div style="display:flex;align-items:center;gap:8px">
        <div class="avatar"><?php echo e($bill->initials); ?></div>
        <div>
          <div style="font-weight:600;color:#1E293B"><?php echo e($bill->patient_name); ?></div>
          <div class="muted" style="font-size:11px"><?php echo e($bill->service); ?></div>
        </div>
      </div>
      <div style="text-align:right">
        <div style="font-weight:600"><?php echo e($bill->formatted_amount); ?></div>
        <?php echo $bill->status_badge; ?>

      </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="muted" style="padding:12px 0">No bills yet.</div>
    <?php endif; ?>
  </div>

  
  <div class="card">
    <div class="card-top">
      <div class="card-title">Outstanding &amp; overdue</div>
      <a href="<?php echo e(route('bills.outstanding')); ?>" class="badge b-red" style="text-decoration:none"><?php echo e($unpaidCount); ?> unpaid</a>
    </div>
    <?php if($unpaidCount === 0): ?>
      <div class="muted" style="padding:12px 0">No outstanding bills 🎉</div>
    <?php else: ?>
    <table>
      <thead>
        <tr>
          <th style="width:20%">Bill no.</th>
          <th style="width:28%">Patient</th>
          <th style="width:20%">Amount</th>
          <th style="width:15%">Status</th>
          <th style="width:17%"></th>
        </tr>
      </thead>
      <tbody>
        <?php $__currentLoopData = $outstandingBills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
          <td class="muted"><?php echo e($bill->bill_no); ?></td>
          <td style="font-weight:600"><?php echo e($bill->patient_name); ?></td>
          <td style="font-weight:600"><?php echo e($bill->formatted_amount); ?></td>
          <td><?php echo $bill->status_badge; ?></td>
          <td>
            <form method="POST" action="<?php echo e(route('bills.pay', $bill)); ?>" style="margin:0">
              <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
              <button type="submit" class="mpbtn">Mark paid</button>
            </form>
          </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>
    <?php endif; ?>
  </div>

</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\crest\wellmeadows-billing\resources\views/dashboard.blade.php ENDPATH**/ ?>