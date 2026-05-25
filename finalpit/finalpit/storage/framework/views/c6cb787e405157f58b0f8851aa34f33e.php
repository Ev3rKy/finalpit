
<?php $__env->startSection('title', 'Billing Dashboard — Wellmeadows'); ?>
<?php $__env->startSection('page_title', 'Billing Dashboard'); ?>
<?php $__env->startSection('sidebar'); ?><?php echo $__env->make('billing.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('top_actions'); ?>
<a href="<?php echo e(route('billing.bills.create')); ?>" class="btn b-teal">+ New Bill</a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="stats">
    <div class="stat navy"><div class="stat-l">Revenue</div><div class="stat-n">₱<?php echo e(number_format($totalRevenue)); ?></div><div class="stat-s">Paid bills</div></div>
    <div class="stat teal"><div class="stat-l">Bills</div><div class="stat-n"><?php echo e($billCount); ?></div><div class="stat-s">Total issued</div></div>
    <div class="stat"><div class="stat-l">Outstanding</div><div class="stat-n">₱<?php echo e(number_format($outstandingAmt)); ?></div><div class="stat-s"><?php echo e($unpaidCount); ?> unpaid</div></div>
    <div class="stat outline"><div class="stat-l">Occupancy</div><div class="stat-n"><?php echo e($occupancyPct); ?>%</div><div class="stat-s"><?php echo e($occupiedBeds); ?>/<?php echo e($totalBeds); ?> beds</div></div>
</div>
<div class="grid-2">
    <div class="card">
        <div class="card-hd"><div class="card-title">Recent Bills</div><a href="<?php echo e(route('billing.bills.index')); ?>" class="act-link">View all →</a></div>
        <table class="tbl">
            <thead><tr><th>Bill</th><th>Patient</th><th>Amount</th><th>Status</th></tr></thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $recentBills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="mono"><?php echo e($bill->bill_no); ?></td>
                <td><?php echo e($bill->patient_name); ?></td>
                <td><?php echo e($bill->formatted_amount); ?></td>
                <td><?php echo $bill->status_badge; ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="4" style="color:var(--muted);padding:20px">No bills yet.</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card">
        <div class="card-hd"><div class="card-title">Outstanding</div><a href="<?php echo e(route('billing.bills.outstanding')); ?>" class="act-link">View all →</a></div>
        <table class="tbl">
            <thead><tr><th>Bill</th><th>Patient</th><th>Due</th><th>Action</th></tr></thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $outstandingBills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="mono"><?php echo e($bill->bill_no); ?></td>
                <td><?php echo e($bill->patient_name); ?></td>
                <td><?php echo e($bill->due_date?->format('d M Y') ?? '—'); ?></td>
                <td>
                    <form method="POST" action="<?php echo e(route('billing.bills.pay', $bill)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                    <button type="submit" class="btn b-teal b-sm">Mark Paid</button></form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="4" style="color:var(--muted);padding:20px">No outstanding bills.</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.module', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\crest\OneDrive\Desktop\finalpit\finalpit\finalpit\resources\views/billing/dashboard.blade.php ENDPATH**/ ?>