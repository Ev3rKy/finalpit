
<?php $__env->startSection('title', 'Treatment History — Wellmeadows'); ?>
<?php $__env->startSection('page_title', 'Treatment History'); ?>
<?php $__env->startSection('sidebar'); ?>
<div class="nav-lbl">Appointments &amp; Treatment</div>
<a href="<?php echo e(route('appointments.dashboard')); ?>" class="ni">Appointments Home</a>
<a href="<?php echo e(route('appointments.schedule')); ?>" class="ni">Appointments</a>
<a href="<?php echo e(route('appointments.medical-record')); ?>" class="ni">Medical Record</a>
<a href="<?php echo e(route('appointments.treatment-history')); ?>" class="ni on">Treatment History</a>
<a href="<?php echo e(route('appointments.assign-staff')); ?>" class="ni">Assign Doctors &amp; Nurses</a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-hd">
        <div class="card-title">Treatment History</div>
        <form method="GET" action="<?php echo e(route('appointments.treatment-history')); ?>" style="display:flex;gap:10px">
            <select name="month" class="sinp" onchange="this.form.submit()">
                <option value="">All Months</option>
                <?php $__currentLoopData = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'May',6=>'Jun',7=>'Jul',8=>'Aug',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n=>$m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($n); ?>" <?php echo e(request('month')==$n?'selected':''); ?>><?php echo e($m); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <select name="year" class="sinp" onchange="this.form.submit()">
                <option value="">All Years</option>
                <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($y); ?>" <?php echo e(request('year')==$y?'selected':''); ?>><?php echo e($y); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </form>
    </div>
    <table class="tbl">
        <thead><tr><th>Patient</th><th>Doctor</th><th>Date</th><th>Procedure</th><th>Notes</th><th>Actions</th></tr></thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php $dt = $rec->treatment_datetime; ?>
        <tr>
            <td><strong><?php echo e($rec->patient_full_name); ?></strong></td>
            <td><?php echo e($rec->doctor); ?></td>
            <td><?php echo e($dt?->format('d M Y g:i A')); ?></td>
            <td><?php echo e($rec->procedure); ?></td>
            <td><?php echo e($rec->medical_notes ? \Illuminate\Support\Str::limit($rec->medical_notes, 40) : '—'); ?></td>
            <td class="td-act">
                <a href="<?php echo e(route('appointments.medical-record')); ?>" class="act-link">Edit in Records →</a>
                <form method="POST" action="<?php echo e(route('appointments.medical-record.destroy', $rec)); ?>" onsubmit="return confirm('Delete record?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button type="submit" class="act-del">Delete</button></form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="6" style="text-align:center;padding:32px;color:var(--muted)">No records found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.module', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\crest\OneDrive\Desktop\finalpit\finalpit\finalpit\resources\views/appointments/treatment-history.blade.php ENDPATH**/ ?>