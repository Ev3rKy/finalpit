<?php $__env->startSection('page-title', 'Patient Bills'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
  <div class="card-top">
    <div class="card-title">All patient bills</div>
    <span class="badge b-blue"><?php echo e($allCount); ?> total</span>
  </div>

  
  <form method="GET" action="<?php echo e(route('bills.index')); ?>" style="display:flex;gap:8px;margin-bottom:14px">
    <input type="text" name="search" value="<?php echo e(request('search')); ?>"
           placeholder="Search name, bill no, patient ID…" class="search-input">
    <select name="status" class="search-select">
      <option value="">All statuses</option>
      <option value="pending" <?php echo e(request('status')==='pending' ? 'selected':''); ?>>Pending</option>
      <option value="paid"    <?php echo e(request('status')==='paid'    ? 'selected':''); ?>>Paid</option>
      <option value="overdue" <?php echo e(request('status')==='overdue' ? 'selected':''); ?>>Overdue</option>
    </select>
    <button type="submit" class="btn btn-primary">Filter</button>
    <?php if(request()->hasAny(['search','status'])): ?>
      <a href="<?php echo e(route('bills.index')); ?>" class="btn">Clear</a>
    <?php endif; ?>
  </form>

  <table>
    <thead>
      <tr>
        <th style="width:11%">Bill no.</th>
        <th style="width:20%">Patient</th>
        <th style="width:9%">Ward</th>
        <th style="width:16%">Service</th>
        <th style="width:11%">Amount</th>
        <th style="width:10%">Due date</th>
        <th style="width:10%">Status</th>
        <th style="width:13%">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php $__empty_1 = true; $__currentLoopData = $bills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <tr>
        <td class="muted"><?php echo e($bill->bill_no); ?></td>
        <td style="font-weight:600"><?php echo e($bill->patient_name); ?></td>
        <td class="muted"><?php echo e($bill->ward->name ?? '—'); ?></td>
        <td class="muted"><?php echo e($bill->service); ?></td>
        <td style="font-weight:600"><?php echo e($bill->formatted_amount); ?></td>
        <td class="<?php echo e($bill->status==='overdue'?'text-red':'muted'); ?>">
          <?php echo e($bill->due_date?->format('M d, Y') ?? 'TBD'); ?>

        </td>
        <td><?php echo $bill->status_badge; ?></td>
        <td>
          <div style="display:flex;gap:4px;flex-wrap:wrap">
            <a href="<?php echo e(route('bills.show', $bill)); ?>" class="action-btn btn-view">View</a>
            <a href="<?php echo e(route('bills.edit', $bill)); ?>" class="action-btn btn-edit">Edit</a>
            <form method="POST" action="<?php echo e(route('bills.destroy', $bill)); ?>"
                  onsubmit="return confirm('Delete <?php echo e($bill->bill_no); ?>? This cannot be undone.')">
              <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
              <button type="submit" class="action-btn btn-delete">Delete</button>
            </form>
          </div>
        </td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <tr>
        <td colspan="8" style="padding:30px 0;text-align:center;color:#94A3B8">
          No bills yet. <a href="<?php echo e(route('bills.create')); ?>" style="color:#185FA5">Generate the first bill →</a>
        </td>
      </tr>
      <?php endif; ?>
    </tbody>
  </table>

  <?php if($bills->hasPages()): ?>
  <div style="margin-top:14px"><?php echo e($bills->links()); ?></div>
  <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\crest\wellmeadows-billing\resources\views/bills/index.blade.php ENDPATH**/ ?>