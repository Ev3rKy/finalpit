
<?php $__env->startSection('title', 'Medical Record — Wellmeadows'); ?>
<?php $__env->startSection('page_title', 'Medical Record'); ?>
<?php $__env->startSection('sidebar'); ?>
<div class="nav-lbl">Appointments &amp; Treatment</div>
<a href="<?php echo e(route('appointments.dashboard')); ?>" class="ni">Appointments Home</a>
<a href="<?php echo e(route('appointments.schedule')); ?>" class="ni">Appointments</a>
<a href="<?php echo e(route('appointments.medical-record')); ?>" class="ni on">Medical Record</a>
<a href="<?php echo e(route('appointments.treatment-history')); ?>" class="ni">Treatment History</a>
<a href="<?php echo e(route('appointments.assign-staff')); ?>" class="ni">Assign Doctors &amp; Nurses</a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('top_actions'); ?>
<button type="button" class="btn b-teal" onclick="document.getElementById('newRecord').classList.add('active')">+ Add Entry</button>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="stats">
    <div class="stat navy"><div class="stat-l">Total Records</div><div class="stat-n"><?php echo e($records->count()); ?></div><div class="stat-s">Treatment entries</div></div>
    <div class="stat teal"><div class="stat-l">This Month</div><div class="stat-n"><?php echo e($records->filter(fn($r) => $r->treatment_datetime?->isCurrentMonth())->count()); ?></div><div class="stat-s">New entries</div></div>
    <div class="stat"><div class="stat-l">Doctors</div><div class="stat-n"><?php echo e($records->pluck('doctor')->unique()->count()); ?></div><div class="stat-s">Contributing</div></div>
    <div class="stat outline"><div class="stat-l">Procedures</div><div class="stat-n"><?php echo e($records->pluck('procedure')->unique()->count()); ?></div><div class="stat-s">Types logged</div></div>
</div>
<div class="card">
    <div class="card-hd"><div class="card-title">Treatment Records</div></div>
    <table class="tbl">
        <thead><tr><th>Patient</th><th>Doctor</th><th>Date &amp; Time</th><th>Procedure</th><th>Vitals</th><th>Actions</th></tr></thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php $dt = $r->treatment_datetime; $vitals = implode(', ', array_filter([$r->bp, $r->temperature, $r->spo2])); ?>
        <tr>
            <td><strong><?php echo e($r->patient_full_name); ?></strong></td>
            <td><?php echo e($r->doctor); ?></td>
            <td><?php echo e($dt?->format('d M Y g:i A')); ?></td>
            <td><?php echo e($r->procedure); ?></td>
            <td><?php echo e($vitals ?: '—'); ?></td>
            <td class="td-act">
                <button type="button" class="btn b-ol b-sm" onclick="openEdit(<?php echo e(json_encode($r)); ?>)">Edit</button>
                <form method="POST" action="<?php echo e(route('appointments.medical-record.destroy', $r)); ?>" onsubmit="return confirm('Delete this record?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button type="submit" class="btn b-dn b-sm">Delete</button></form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="6" style="text-align:center;padding:32px;color:var(--muted)">No treatment records yet.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<div id="newRecord" class="modal-overlay" onclick="if(event.target===this)this.classList.remove('active')">
    <div class="modal" style="max-width:640px"><h3 style="margin-bottom:16px">Add Treatment Record</h3>
    <form method="POST" action="<?php echo e(route('appointments.medical-record.store')); ?>"><?php echo csrf_field(); ?>
        <?php echo $__env->make('appointments.partials.treatment-form', ['doctors' => $doctors], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <button type="submit" class="btn b-teal" style="margin-top:14px">Save Record</button>
    </form></div>
</div>
<div id="editRecord" class="modal-overlay" onclick="if(event.target===this)this.classList.remove('active')">
    <div class="modal" style="max-width:640px"><h3 style="margin-bottom:16px">Edit Treatment Record</h3>
    <form id="editRecordForm" method="POST"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <?php echo $__env->make('appointments.partials.treatment-form', ['doctors' => $doctors, 'prefix' => 'er_'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <button type="submit" class="btn b-teal" style="margin-top:14px">Update</button>
    </form></div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
function openEdit(r) {
    document.getElementById('editRecordForm').action = '<?php echo e(url('/appointments/medical-record')); ?>/' + r.id;
    const fields = ['patient_full_name','doctor','procedure','bp','temperature','spo2','medical_notes','phone_no'];
    fields.forEach(f => { const el = document.querySelector('#editRecord [name="'+f+'"]'); if (el) el.value = r[f] ?? ''; });
    const dt = document.querySelector('#editRecord [name="treatment_datetime"]');
    if (dt && r.treatment_datetime) dt.value = r.treatment_datetime.replace(' ', 'T').substring(0,16);
    document.getElementById('editRecord').classList.add('active');
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.module', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\pausa\Downloads\V.2\finalpit\finalpit\finalpit\resources\views/appointments/medical-record.blade.php ENDPATH**/ ?>