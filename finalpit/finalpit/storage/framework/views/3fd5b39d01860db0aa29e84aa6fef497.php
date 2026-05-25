
<?php $__env->startSection('title', 'Occupancy Report — Wellmeadows'); ?>
<?php $__env->startSection('page_title', 'Occupancy Report'); ?>
<?php $__env->startSection('sidebar'); ?><?php echo $__env->make('billing.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<p style="font-size:12px;color:var(--muted);margin-bottom:16px">Occupied and vacant counts update automatically when patients are admitted, assigned to a ward, or discharged.</p>
<div class="card">
    <div class="card-hd"><div class="card-title">Ward Occupancy</div></div>
    <table class="tbl">
        <thead><tr><th>Ward</th><th>Total Beds</th><th>Occupied</th><th>Vacant</th><th>Rate</th></tr></thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $wards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ward): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php $vacant = $ward->total_beds - $ward->occupied_beds; $pct = $ward->total_beds > 0 ? round(($ward->occupied_beds / $ward->total_beds) * 100) : 0; ?>
        <tr>
            <td><strong><?php echo e($ward->name); ?></strong><?php if($ward->ward_type): ?><span style="color:var(--muted);font-size:11px;margin-left:6px"><?php echo e($ward->ward_type); ?></span><?php endif; ?></td>
            <td><?php echo e($ward->total_beds); ?></td>
            <td><?php echo e($ward->occupied_beds); ?></td>
            <td><?php echo e($vacant); ?></td>
            <td><span class="bdg <?php echo e($pct >= 80 ? 'br' : ($pct >= 50 ? 'bo' : 'bp')); ?>"><?php echo e($pct); ?>%</span></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="5" style="text-align:center;padding:32px;color:var(--muted)">No wards yet. Create wards in <a href="<?php echo e(route('ward-beds.index')); ?>">Ward &amp; Bed Management</a>.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.module', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\pausa\Downloads\V.2\finalpit\finalpit\finalpit\resources\views/billing/reports/occupancy.blade.php ENDPATH**/ ?>