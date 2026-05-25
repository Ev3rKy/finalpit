<?php $__env->startSection('page-title', 'Bill Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="card" style="max-width:600px">
  <div class="card-top">
    <div>
      <div class="card-title"><?php echo e($bill->bill_no); ?></div>
      <div class="muted" style="font-size:11px;margin-top:2px">Generated <?php echo e($bill->created_at->format('F d, Y')); ?></div>
    </div>
    <?php echo $bill->status_badge; ?>

  </div>

  <div class="detail-grid">
    <div class="detail-row">
      <span class="detail-label">Patient name</span>
      <span class="detail-value"><?php echo e($bill->patient_name); ?></span>
    </div>
    <div class="detail-row">
      <span class="detail-label">Patient ID</span>
      <span class="detail-value"><?php echo e($bill->patient_id); ?></span>
    </div>
    <div class="detail-row">
      <span class="detail-label">Ward</span>
      <span class="detail-value"><?php echo e($bill->ward->name ?? '—'); ?></span>
    </div>
    <div class="detail-row">
      <span class="detail-label">Service</span>
      <span class="detail-value"><?php echo e($bill->service); ?></span>
    </div>
    <div class="detail-row">
      <span class="detail-label">Amount</span>
      <span class="detail-value" style="font-size:16px;font-weight:700;color:#185FA5"><?php echo e($bill->formatted_amount); ?></span>
    </div>
    <div class="detail-row">
      <span class="detail-label">Due date</span>
      <span class="detail-value <?php echo e($bill->status==='overdue'?'text-red':''); ?>">
        <?php echo e($bill->due_date?->format('F d, Y') ?? 'Not set'); ?>

      </span>
    </div>
    <?php if($bill->paid_at): ?>
    <div class="detail-row">
      <span class="detail-label">Paid on</span>
      <span class="detail-value" style="color:#27500A"><?php echo e($bill->paid_at->format('F d, Y h:i A')); ?></span>
    </div>
    <?php endif; ?>
  </div>

  <div class="divider"></div>

  <div style="display:flex;gap:8px;flex-wrap:wrap">
    <a href="<?php echo e(route('bills.edit', $bill)); ?>" class="btn btn-primary">Edit bill</a>

    <?php if($bill->status !== 'paid'): ?>
    <form method="POST" action="<?php echo e(route('bills.pay', $bill)); ?>" style="margin:0">
      <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
      <button type="submit" class="btn" style="background:#EAF3DE;color:#27500A;border-color:#3B6D11">
        ✓ Mark as paid
      </button>
    </form>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('bills.destroy', $bill)); ?>" style="margin:0"
          onsubmit="return confirm('Delete <?php echo e($bill->bill_no); ?>? This cannot be undone.')">
      <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
      <button type="submit" class="btn" style="background:#FCEBEB;color:#791F1F;border-color:#E24B4A">
        Delete bill
      </button>
    </form>

    <a href="<?php echo e(route('bills.index')); ?>" class="btn">← Back to bills</a>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\crest\wellmeadows-billing\resources\views/bills/show.blade.php ENDPATH**/ ?>