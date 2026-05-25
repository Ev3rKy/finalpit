<?php $__env->startSection('page-title', 'Outstanding'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
  <div class="card-top">
    <div class="card-title">Outstanding &amp; overdue bills</div>
    <span class="badge b-red"><?php echo e($unpaidCount); ?> unpaid</span>
  </div>

  <div style="display:flex;gap:12px;margin-bottom:16px">
    <div class="metric" style="border-top:3px solid #E24B4A;flex:1">
      <div class="metric-label">Total outstanding</div>
      <div class="metric-value" style="font-size:18px">₱<?php echo e(number_format($outstandingAmt)); ?></div>
    </div>
    <div class="metric" style="border-top:3px solid #378ADD;flex:1">
      <div class="metric-label">Unpaid bills</div>
      <div class="metric-value" style="font-size:18px"><?php echo e($unpaidCount); ?></div>
    </div>
  </div>

  <table>
    <thead>
      <tr>
        <th style="width:12%">Bill no.</th>
        <th style="width:20%">Patient</th>
        <th style="width:11%">Ward</th>
        <th style="width:13%">Amount</th>
        <th style="width:12%">Due date</th>
        <th style="width:11%">Status</th>
        <th style="width:21%">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php $__empty_1 = true; $__currentLoopData = $bills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <tr>
        <td class="muted"><?php echo e($bill->bill_no); ?></td>
        <td style="font-weight:600"><?php echo e($bill->patient_name); ?></td>
        <td class="muted"><?php echo e($bill->ward->name ?? '—'); ?></td>
        <td style="font-weight:600"><?php echo e($bill->formatted_amount); ?></td>
        <td style="<?php echo e($bill->status==='overdue' ? 'color:#A32D2D' : ''); ?>">
          <?php echo e($bill->due_date?->format('M d, Y') ?? 'TBD'); ?>

        </td>
        <td><?php echo $bill->status_badge; ?></td>
        <td>
          <div style="display:flex;gap:4px;flex-wrap:wrap">
            <form method="POST" action="<?php echo e(route('bills.pay', $bill)); ?>" style="margin:0">
              <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
              <button type="submit" class="mpbtn">Mark paid</button>
            </form>
            <a href="<?php echo e(route('bills.edit', $bill)); ?>" class="action-btn btn-edit">Edit</a>
            <form method="POST" action="<?php echo e(route('bills.destroy', $bill)); ?>" style="margin:0"
                  onsubmit="return confirm('Delete <?php echo e($bill->bill_no); ?>?')">
              <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
              <button type="submit" class="action-btn btn-delete">Delete</button>
            </form>
          </div>
        </td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <tr>
        <td colspan="7" style="padding:30px 0;text-align:center;color:#94A3B8">
          No outstanding bills — all caught up! 🎉
        </td>
      </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\crest\wellmeadows-billing\resources\views/bills/outstanding.blade.php ENDPATH**/ ?>