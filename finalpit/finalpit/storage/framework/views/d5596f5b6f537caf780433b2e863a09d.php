<?php $__env->startSection('title', 'Appointments — Wellmeadows'); ?>
<?php $__env->startSection('page_title', 'Appointments Home'); ?>
<?php $__env->startSection('sidebar'); ?>
<div class="nav-lbl">Appointments &amp; Treatment</div>
<a href="<?php echo e(route('appointments.dashboard')); ?>" class="ni on">Appointments Home</a>
<a href="<?php echo e(route('appointments.schedule')); ?>" class="ni">Appointments</a>
<a href="<?php echo e(route('appointments.medical-record')); ?>" class="ni">Medical Record</a>
<a href="<?php echo e(route('appointments.treatment-history')); ?>" class="ni">Treatment History</a>
<a href="<?php echo e(route('appointments.assign-staff')); ?>" class="ni">Assign Doctors &amp; Nurses</a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="stats">
    <div class="stat navy"><div class="stat-l">Appointments</div><div class="stat-n"><?php echo e($appointmentCount); ?></div><div class="stat-s">Scheduled total</div></div>
    <div class="stat teal"><div class="stat-l">Treatment Records</div><div class="stat-n"><?php echo e($treatmentCount); ?></div><div class="stat-s">On file</div></div>
    <div class="stat"><div class="stat-l">Active Tasks</div><div class="stat-n"><?php echo e($taskCount); ?></div><div class="stat-s">Staff assignments</div></div>
    <div class="stat outline"><div class="stat-l">Today</div><div class="stat-n"><?php echo e(date('d')); ?></div><div class="stat-s"><?php echo e(date('M Y')); ?></div></div>
</div>
<div class="grid-2">
    <a href="<?php echo e(route('appointments.schedule')); ?>" class="card" style="padding:24px;text-decoration:none;color:inherit"><div class="card-title">Schedule Appointment</div><div class="card-sub">Create and manage patient appointments →</div></a>
    <a href="<?php echo e(route('appointments.medical-record')); ?>" class="card" style="padding:24px;text-decoration:none;color:inherit"><div class="card-title">Medical Records</div><div class="card-sub">Add treatment entries and vitals →</div></a>
    <a href="<?php echo e(route('appointments.treatment-history')); ?>" class="card" style="padding:24px;text-decoration:none;color:inherit"><div class="card-title">Treatment History</div><div class="card-sub">Browse past procedures →</div></a>
    <a href="<?php echo e(route('appointments.assign-staff')); ?>" class="card" style="padding:24px;text-decoration:none;color:inherit"><div class="card-title">Staff Assignment</div><div class="card-sub">Assign doctors and nurses to tasks →</div></a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.module', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\pausa\Downloads\V.2\finalpit\finalpit\finalpit\resources\views/appointments/dashboard.blade.php ENDPATH**/ ?>