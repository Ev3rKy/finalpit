
<?php $__env->startSection('title', 'Billing Wards — Wellmeadows'); ?>
<?php $__env->startSection('page_title', 'Ward Rates'); ?>
<?php $__env->startSection('sidebar'); ?><?php echo $__env->make('billing.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('top_actions'); ?>
<a href="<?php echo e(route('billing.wards.create')); ?>" class="btn b-teal">+ Add Ward</a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-hd"><div class="card-title">Billing Wards</div><div class="card-sub">Ward capacity for billing &amp; occupancy</div></div>
    <table class="tbl">
        <thead><tr><th>Ward Name</th><th>Type</th><th>Capacity</th><th>Occupied</th><th>Vacant</th><th>Rate</th><th>Actions</th></tr></thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $wards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ward): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php $pct = $ward->total_beds > 0 ? round(($ward->occupied_beds / $ward->total_beds) * 100) : 0; $vacant = max(0, $ward->total_beds - $ward->occupied_beds); ?>
        <tr>
            <td><strong><?php echo e($ward->name); ?></strong></td>
            <td><?php echo e($ward->ward_type ?? '—'); ?></td>
            <td><?php echo e($ward->total_beds); ?></td>
            <td><?php echo e($ward->occupied_beds); ?></td>
            <td><?php echo e($vacant); ?></td>
            <td><span class="bdg <?php echo e($pct >= 75 ? 'bo' : 'bp'); ?>"><?php echo e($pct); ?>%</span></td>
            <td class="td-act">
                <a href="<?php echo e(route('billing.wards.edit', $ward)); ?>" class="act-link">Edit →</a>
                <form method="POST" action="<?php echo e(route('billing.wards.destroy', $ward)); ?>" onsubmit="return confirm('Delete this ward?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button type="submit" class="act-del">Delete</button></form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="7" style="text-align:center;padding:32px;color:var(--muted)">No wards yet. <a href="<?php echo e(route('billing.wards.create')); ?>">Add a ward</a> to track capacity and occupancy.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.module', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\crest\OneDrive\Desktop\finalpit\finalpit\finalpit\resources\views/billing/wards/index.blade.php ENDPATH**/ ?>