
<?php $__env->startSection('title', 'Outstanding Bills — Wellmeadows'); ?>
<?php $__env->startSection('page_title', 'Outstanding Bills'); ?>
<?php $__env->startSection('sidebar'); ?><?php echo $__env->make('billing.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('top_actions'); ?>
<a href="<?php echo e(route('billing.bills.create')); ?>" class="btn b-teal">+ New Bill</a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="stats">
    <div class="stat navy"><div class="stat-l">Unpaid Bills</div><div class="stat-n"><?php echo e($unpaidCount); ?></div><div class="stat-s">Pending + overdue</div></div>
    <div class="stat teal"><div class="stat-l">Total Outstanding</div><div class="stat-n">₱<?php echo e(number_format($outstandingAmt)); ?></div><div class="stat-s">Amount due</div></div>
</div>
<div class="card">
    <div class="card-hd"><div class="card-title">Outstanding Register</div></div>
    <table class="tbl">
        <thead><tr><th>Bill</th><th>Patient</th><th>Ward</th><th>Amount</th><th>Due</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $bills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td class="mono"><?php echo e($bill->bill_no); ?></td>
            <td><?php echo e($bill->patient_name); ?></td>
            <td><?php echo e($bill->ward?->name ?? '—'); ?></td>
            <td><?php echo e($bill->formatted_amount); ?></td>
            <td><?php echo e($bill->due_date?->format('d M Y') ?? '—'); ?></td>
            <td><?php echo $bill->status_badge; ?></td>
            <td class="td-act">
                <a href="<?php echo e(route('billing.bills.edit', $bill)); ?>" class="act-link">Edit →</a>
                <form method="POST" action="<?php echo e(route('billing.bills.pay', $bill)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><button type="submit" class="btn b-teal b-sm">Mark Paid</button></form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="7" style="text-align:center;padding:32px;color:var(--muted)">No outstanding bills.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.module', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\crest\OneDrive\Desktop\finalpit\finalpit\finalpit\resources\views/billing/bills/outstanding.blade.php ENDPATH**/ ?>