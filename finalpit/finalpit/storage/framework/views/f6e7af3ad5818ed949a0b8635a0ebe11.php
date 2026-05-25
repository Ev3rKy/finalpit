
<?php $__env->startSection('title', 'Appointments — Wellmeadows'); ?>
<?php $__env->startSection('page_title', 'Patient Appointments'); ?>
<?php $__env->startSection('sidebar'); ?>
<div class="nav-lbl">Appointments &amp; Treatment</div>
<a href="<?php echo e(route('appointments.dashboard')); ?>" class="ni">Appointments Home</a>
<a href="<?php echo e(route('appointments.schedule')); ?>" class="ni on">Appointments</a>
<a href="<?php echo e(route('appointments.medical-record')); ?>" class="ni">Medical Record</a>
<a href="<?php echo e(route('appointments.treatment-history')); ?>" class="ni">Treatment History</a>
<a href="<?php echo e(route('appointments.assign-staff')); ?>" class="ni">Assign Doctors &amp; Nurses</a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('top_actions'); ?>
<button type="button" class="btn b-teal" onclick="document.getElementById('newAppt').classList.add('active')">+ New Appointment</button>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="stats">
    <div class="stat navy"><div class="stat-l">Total Scheduled</div><div class="stat-n"><?php echo e($appointments->count()); ?></div><div class="stat-s">All appointments</div></div>
    <div class="stat teal"><div class="stat-l">Today &amp; Upcoming</div><div class="stat-n"><?php echo e($appointments->where('appointment_date', '>=', $today)->count()); ?></div><div class="stat-s">Active schedule</div></div>
    <div class="stat"><div class="stat-l">Past</div><div class="stat-n"><?php echo e($appointments->where('appointment_date', '<', $today)->count()); ?></div><div class="stat-s">Completed / past</div></div>
    <div class="stat outline"><div class="stat-l">Departments</div><div class="stat-n"><?php echo e($appointments->pluck('medical_department')->unique()->count()); ?></div><div class="stat-s">In use</div></div>
</div>
<div class="card">
    <div class="card-hd"><div class="card-title">Appointment Register</div></div>
    <table class="tbl">
        <thead><tr><th>Patient</th><th>Date</th><th>Time</th><th>Department</th><th>Doctor</th><th>Actions</th></tr></thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><strong><?php echo e($a->full_name); ?></strong></td>
            <td><?php echo e($a->appointment_date?->format('d M Y')); ?></td>
            <td><?php echo e($a->appointment_time); ?></td>
            <td><?php echo e($a->medical_department); ?></td>
            <td><?php echo e($a->doctor); ?></td>
            <td class="td-act">
                <button type="button" class="btn b-ol b-sm" onclick="openEdit(<?php echo e(json_encode($a)); ?>)">Edit</button>
                <form method="POST" action="<?php echo e(route('appointments.schedule.destroy', $a)); ?>" onsubmit="return confirm('Cancel this appointment?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button type="submit" class="btn b-dn b-sm">Delete</button></form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="6" style="text-align:center;padding:32px;color:var(--muted)">No appointments yet.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<div id="newAppt" class="modal-overlay" onclick="if(event.target===this)this.classList.remove('active')">
    <div class="modal" style="max-width:640px"><h3 style="margin-bottom:16px">New Appointment</h3>
    <form method="POST" action="<?php echo e(route('appointments.schedule.store')); ?>"><?php echo csrf_field(); ?>
        <?php echo $__env->make('appointments.partials.appointment-form', ['doctors' => $doctors], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <button type="submit" class="btn b-teal" style="margin-top:14px">Schedule</button>
    </form></div>
</div>
<div id="editAppt" class="modal-overlay" onclick="if(event.target===this)this.classList.remove('active')">
    <div class="modal" style="max-width:640px"><h3 style="margin-bottom:16px">Edit Appointment</h3>
    <form id="editApptForm" method="POST"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <?php echo $__env->make('appointments.partials.appointment-form', ['doctors' => $doctors, 'prefix' => 'edit_'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <button type="submit" class="btn b-teal" style="margin-top:14px">Update</button>
    </form></div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
function openEdit(a) {
    document.getElementById('editApptForm').action = '<?php echo e(url('/appointments/schedule')); ?>/' + a.id;
    const modal = document.getElementById('editAppt');
    const set = (n, v) => { const el = modal.querySelector('[name="'+n+'"]'); if (el) el.value = v ?? ''; };
    set('full_name', a.full_name);
    set('appointment_date', a.appointment_date ? a.appointment_date.substring(0, 10) : '');
    set('appointment_time', a.appointment_time);
    set('medical_department', a.medical_department);
    set('doctor', a.doctor);
    set('phone_no', a.phone_no);
    set('complete_address', a.complete_address);
    document.getElementById('editAppt').classList.add('active');
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.module', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\crest\OneDrive\Desktop\finalpit\finalpit\finalpit\resources\views/appointments/appointment.blade.php ENDPATH**/ ?>