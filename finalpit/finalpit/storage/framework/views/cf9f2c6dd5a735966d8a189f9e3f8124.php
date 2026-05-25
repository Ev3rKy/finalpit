
<?php $__env->startSection('title', 'Bills — Wellmeadows'); ?>
<?php $__env->startSection('page_title', 'Patient Bills'); ?>
<?php $__env->startSection('sidebar'); ?><?php echo $__env->make('billing.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('top_actions'); ?>
<a href="<?php echo e(route('billing.bills.create')); ?>" class="btn b-teal">+ New Bill</a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="stats">
    <div class="stat navy"><div class="stat-l">All Bills</div><div class="stat-n"><?php echo e($allCount); ?></div><div class="stat-s">Total records</div></div>
    <div class="stat teal"><div class="stat-l">This Page</div><div class="stat-n"><?php echo e($bills->count()); ?></div><div class="stat-s">Showing now</div></div>
</div>
<div class="card">
    <div class="card-hd">
        <div class="card-title">Bill Register</div>
        <form method="GET" style="display:flex;gap:10px;flex-wrap:wrap">
            <input type="text" name="search" class="sinp" value="<?php echo e(request('search')); ?>" placeholder="Search patient or bill no…">
            <select name="status" class="sinp" onchange="this.form.submit()">
                <option value="">All statuses</option>
                <option value="pending" <?php echo e(request('status')==='pending'?'selected':''); ?>>Pending</option>
                <option value="paid" <?php echo e(request('status')==='paid'?'selected':''); ?>>Paid</option>
                <option value="overdue" <?php echo e(request('status')==='overdue'?'selected':''); ?>>Overdue</option>
            </select>
            <button type="submit" class="btn b-ol">Search</button>
        </form>
    </div>
    <table class="tbl">
        <thead><tr><th>Bill No.</th><th>Patient</th><th>Ward</th><th>Service</th><th>Amount</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $bills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td class="mono"><?php echo e($bill->bill_no); ?></td>
            <td><div class="p-info"><div class="p-av"><?php echo e($bill->initials); ?></div><strong><?php echo e($bill->patient_name); ?></strong></div></td>
            <td><?php echo e($bill->ward?->name ?? '—'); ?></td>
            <td><?php echo e($bill->service); ?></td>
            <td><?php echo e($bill->formatted_amount); ?></td>
            <td><?php echo $bill->status_badge; ?></td>
            <td class="td-act">
                <a href="<?php echo e(route('billing.bills.show', $bill)); ?>" class="act-link">View →</a>
                <a href="<?php echo e(route('billing.bills.edit', $bill)); ?>" class="act-link">Edit →</a>
                <?php if($bill->status !== 'paid'): ?>
                <form method="POST" action="<?php echo e(route('billing.bills.pay', $bill)); ?>" style="display:inline"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><button type="submit" class="btn b-teal b-sm">Pay</button></form>
                <?php endif; ?>
                <form method="POST" action="<?php echo e(route('billing.bills.destroy', $bill)); ?>" style="display:inline" onsubmit="return confirm('Delete this bill?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button type="submit" class="act-del">Delete</button></form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="7" style="text-align:center;padding:32px;color:var(--muted)">No bills found. <a href="<?php echo e(route('billing.bills.create')); ?>">Create one →</a></td></tr>
        <?php endif; ?>
        </tbody>
    </table>
    <?php if($bills->hasPages()): ?><div style="padding:16px 20px"><?php echo e($bills->links()); ?></div><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.module', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\crest\OneDrive\Desktop\finalpit\finalpit\finalpit\resources\views/billing/bills/index.blade.php ENDPATH**/ ?>