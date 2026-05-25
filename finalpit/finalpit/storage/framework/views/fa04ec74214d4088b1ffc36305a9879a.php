
<?php $__env->startSection('title', 'Summaries — Wellmeadows'); ?>
<?php $__env->startSection('page_title', 'Hospital Summaries'); ?>
<?php $__env->startSection('sidebar'); ?><?php echo $__env->make('billing.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="stats">
    <div class="stat navy"><div class="stat-l">Patients</div><div class="stat-n"><?php echo e($patientCount); ?></div><div class="stat-s">Registered</div></div>
    <div class="stat teal"><div class="stat-l">Bills</div><div class="stat-n"><?php echo e($billCount); ?></div><div class="stat-s">Total issued</div></div>
    <div class="stat"><div class="stat-l">Revenue</div><div class="stat-n">₱<?php echo e(number_format($revenue)); ?></div><div class="stat-s">Collected</div></div>
    <div class="stat outline"><div class="stat-l">Outstanding</div><div class="stat-n">₱<?php echo e(number_format($outstanding)); ?></div><div class="stat-s"><?php echo e($occupancy); ?>% occupancy</div></div>
</div>
<div class="card" style="padding:24px">
    <p style="font-size:13px;color:var(--muted);line-height:1.7">Hospital-wide summary for billing and reporting. Use the sidebar to manage bills, wards, and detailed reports.</p>
    <div style="margin-top:20px;display:flex;gap:10px;flex-wrap:wrap">
        <a href="<?php echo e(route('billing.bills.index')); ?>" class="btn b-teal">View Bills</a>
        <a href="<?php echo e(route('billing.reports.patients')); ?>" class="btn b-ol">Patient Records</a>
        <a href="<?php echo e(route('billing.reports.revenue')); ?>" class="btn b-ol">Revenue Report</a>
        <a href="<?php echo e(route('billing.reports.occupancy')); ?>" class="btn b-ol">Occupancy Report</a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.module', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\crest\OneDrive\Desktop\finalpit\finalpit\finalpit\resources\views/billing/reports/summaries.blade.php ENDPATH**/ ?>