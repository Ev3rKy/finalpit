
<?php $__env->startSection('title', 'Patient Records Report — Wellmeadows'); ?>
<?php $__env->startSection('page_title', 'Patient Records Report'); ?>
<?php $__env->startSection('sidebar'); ?><?php echo $__env->make('billing.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-hd">
        <div class="card-title">All Patient Records</div>
        <div class="card-sub"><?php echo e($patients->count()); ?> registered patients</div>
    </div>
    <table class="tbl">
        <thead><tr><th>Patient</th><th>Patient No.</th><th>DOB</th><th>Status</th><th>Admissions</th><th>Medications</th><th>Registered</th></tr></thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><div class="p-info"><div class="p-av"><?php echo e($p->initials); ?></div><strong><?php echo e($p->name); ?></strong></div></td>
            <td class="mono"><?php echo e($p->patient_no); ?></td>
            <td><?php echo e($p->date_of_birth?->format('d M Y') ?? '—'); ?></td>
            <td><span class="bdg <?php echo e($p->status === 'IN-PATIENT' ? 'bp' : 'bo'); ?>"><?php echo e($p->status); ?></span></td>
            <td><?php echo e($p->admissions_count); ?></td>
            <td><?php echo e($p->medications_count); ?></td>
            <td><?php echo e($p->date_registered?->format('d M Y')); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="7" style="text-align:center;padding:32px;color:var(--muted)">No patients registered yet. Add patients in Patient Management.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.module', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\pausa\Downloads\V.2\finalpit\finalpit\finalpit\resources\views/billing/reports/patients.blade.php ENDPATH**/ ?>