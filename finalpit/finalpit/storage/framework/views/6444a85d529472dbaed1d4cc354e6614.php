
<?php $__env->startSection('title', 'Revenue Report — Wellmeadows'); ?>
<?php $__env->startSection('page_title', 'Revenue Report'); ?>
<?php $__env->startSection('sidebar'); ?><?php echo $__env->make('billing.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="stat navy" style="border-radius:10px;padding:20px;margin-bottom:20px;max-width:320px">
    <div class="stat-l">Total Revenue</div>
    <div class="stat-n">₱<?php echo e(number_format($total)); ?></div>
    <div class="stat-s">From paid bills</div>
</div>
<div class="card">
    <div class="card-hd"><div class="card-title">Paid Bills</div></div>
    <table class="tbl">
        <thead><tr><th>Bill</th><th>Patient</th><th>Service</th><th>Amount</th><th>Paid</th><th>Actions</th></tr></thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $bills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td class="mono"><?php echo e($b->bill_no); ?></td>
            <td><?php echo e($b->patient_name); ?></td>
            <td><?php echo e($b->service); ?></td>
            <td><?php echo e($b->formatted_amount); ?></td>
            <td><?php echo e($b->paid_at?->format('d M Y') ?? '—'); ?></td>
            <td><a href="<?php echo e(route('billing.bills.show', $b)); ?>" class="act-link">View →</a></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="6" style="padding:24px;color:var(--muted)">No paid bills yet.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.module', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\crest\OneDrive\Desktop\finalpit\finalpit\finalpit\resources\views/billing/reports/revenue.blade.php ENDPATH**/ ?>