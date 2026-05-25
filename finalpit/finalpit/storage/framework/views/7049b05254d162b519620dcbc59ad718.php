
<?php $__env->startSection('title', 'Staff Assignment — Wellmeadows'); ?>
<?php $__env->startSection('page_title', 'Assign Doctors & Nurses'); ?>
<?php $__env->startSection('sidebar'); ?>
<div class="nav-lbl">Appointments &amp; Treatment</div>
<a href="<?php echo e(route('appointments.dashboard')); ?>" class="ni">Appointments Home</a>
<a href="<?php echo e(route('appointments.schedule')); ?>" class="ni">Appointments</a>
<a href="<?php echo e(route('appointments.medical-record')); ?>" class="ni">Medical Record</a>
<a href="<?php echo e(route('appointments.treatment-history')); ?>" class="ni">Treatment History</a>
<a href="<?php echo e(route('appointments.assign-staff')); ?>" class="ni on">Assign Doctors &amp; Nurses</a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('top_actions'); ?>
<button type="button" class="btn b-teal" onclick="document.getElementById('newTask').classList.add('active')">+ Assign Staff</button>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="stats">
    <div class="stat navy"><div class="stat-l">Total Tasks</div><div class="stat-n"><?php echo e($tasks->count()); ?></div><div class="stat-s">All assignments</div></div>
    <div class="stat teal"><div class="stat-l">Active</div><div class="stat-n"><?php echo e($tasks->where('is_completed', false)->count()); ?></div><div class="stat-s">In progress</div></div>
    <div class="stat"><div class="stat-l">Completed</div><div class="stat-n"><?php echo e($tasks->where('is_completed', true)->count()); ?></div><div class="stat-s">Done</div></div>
    <div class="stat outline"><div class="stat-l">Doctors</div><div class="stat-n"><?php echo e($doctors->count()); ?></div><div class="stat-s">Available</div></div>
</div>
<div class="card">
    <div class="card-hd"><div class="card-title">Staff Assignments</div></div>
    <table class="tbl">
        <thead><tr><th>Patient</th><th>Treatment</th><th>Assigned Staff</th><th>Role</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><strong><?php echo e($t->patient_full_name); ?></strong></td>
            <td><?php echo e($t->treatment_type); ?></td>
            <td><?php echo e($t->assigned_staff); ?></td>
            <td><span class="bdg <?php echo e($t->staff_type === 'doctor' ? 'bp' : 'bo'); ?>"><?php echo e(ucfirst($t->staff_type)); ?></span></td>
            <td><span class="bdg <?php echo e($t->is_completed ? 'bp' : 'bo'); ?>"><?php echo e($t->is_completed ? 'Done' : 'Active'); ?></span></td>
            <td class="td-act">
                <button type="button" class="btn b-ol b-sm" onclick="openEdit(<?php echo e(json_encode($t)); ?>)">Edit</button>
                <form method="POST" action="<?php echo e(route('appointments.assign-staff.destroy', $t)); ?>" onsubmit="return confirm('Remove assignment?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button type="submit" class="btn b-dn b-sm">Delete</button></form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="6" style="text-align:center;padding:32px;color:var(--muted)">No staff assignments yet.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<div id="newTask" class="modal-overlay" onclick="if(event.target===this)this.classList.remove('active')">
    <div class="modal"><h3 style="margin-bottom:16px">Assign Staff</h3>
    <form method="POST" action="<?php echo e(route('appointments.assign-staff.store')); ?>"><?php echo csrf_field(); ?>
        <?php echo $__env->make('appointments.partials.assign-form', ['doctors' => $doctors, 'nurses' => $nurses], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <button type="submit" class="btn b-teal" style="margin-top:14px">Assign</button>
    </form></div>
</div>
<div id="editTask" class="modal-overlay" onclick="if(event.target===this)this.classList.remove('active')">
    <div class="modal"><h3 style="margin-bottom:16px">Edit Assignment</h3>
    <form id="editTaskForm" method="POST"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <?php echo $__env->make('appointments.partials.assign-form', ['doctors' => $doctors, 'nurses' => $nurses, 'edit' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <button type="submit" class="btn b-teal" style="margin-top:14px">Update</button>
    </form></div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
function openEdit(t) {
    document.getElementById('editTaskForm').action = '<?php echo e(url('/appointments/assign-staff')); ?>/' + t.id;
    document.querySelector('#editTask [name="patient_full_name"]').value = t.patient_full_name;
    document.querySelector('#editTask [name="treatment_type"]').value = t.treatment_type;
    document.querySelector('#editTask [name="staff_type"]').value = t.staff_type;
    document.querySelector('#editTask [name="is_completed"]').checked = t.is_completed;
    updateStaffList(t.staff_type, t.assigned_staff);
    document.getElementById('editTask').classList.add('active');
}
function updateStaffList(type, selected) {
    const sel = document.querySelector('#editTask.open [name="assigned_staff"]') || document.querySelector('#newTask.open [name="assigned_staff"]') || document.querySelector('[name="assigned_staff"]');
    if (!sel) return;
    const doctors = <?php echo json_encode($doctors->pluck('full_name'), 15, 512) ?>;
    const nurses = <?php echo json_encode($nurses->pluck('full_name'), 15, 512) ?>;
    const list = type === 'nurse' ? nurses : doctors;
    sel.innerHTML = list.map(n => '<option value="'+n+'"'+(n===selected?' selected':'')+'>'+n+'</option>').join('');
}
document.querySelectorAll('[name="staff_type"]').forEach(el => el.addEventListener('change', function() { updateStaffList(this.value, ''); }));
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.module', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\crest\OneDrive\Desktop\finalpit\finalpit\finalpit\resources\views/appointments/assign-staff.blade.php ENDPATH**/ ?>