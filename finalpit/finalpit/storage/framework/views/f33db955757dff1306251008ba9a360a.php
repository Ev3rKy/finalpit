
<?php $__env->startSection('title', 'Ward & Bed — Wellmeadows'); ?>
<?php $__env->startSection('page_title', 'Ward & Bed Assignment'); ?>
<?php $__env->startSection('sidebar'); ?>
<div class="nav-lbl">Ward &amp; Bed Management</div>
<a href="<?php echo e(route('ward-beds.index')); ?>" class="ni on">Bed Matrix</a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('top_actions'); ?>
<button type="button" class="btn b-teal" onclick="document.getElementById('newBed').classList.add('active')">+ Add Bed</button>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="stats">
    <div class="stat navy"><div class="stat-l">Total Beds</div><div class="stat-n"><?php echo e($beds->count()); ?></div><div class="stat-s">All wards</div></div>
    <div class="stat teal"><div class="stat-l">Occupied</div><div class="stat-n"><?php echo e($occupiedCount); ?></div><div class="stat-s"><?php echo e($occupancyRate); ?>% Occupancy</div></div>
    <div class="stat"><div class="stat-l">Vacant</div><div class="stat-n"><?php echo e($availableCount); ?></div><div class="stat-s">Available Now</div></div>
    <div class="stat outline"><div class="stat-l">Cleaning</div><div class="stat-n"><?php echo e($cleaningCount); ?></div><div class="stat-s">Being prepared</div></div>
</div>
<div class="card">
    <div class="card-hd">
        <div><div class="card-title">Bed Allocation Matrix</div><div class="card-sub">Assign, edit, or free beds</div></div>
        <form method="GET"><input type="text" name="search" class="sinp" value="<?php echo e($search ?? ''); ?>" placeholder="Search bed or patient…"></form>
    </div>
    <table class="tbl">
        <thead><tr><th>Bed</th><th>Status</th><th>Patient</th><th>Actions</th></tr></thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $beds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bed): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><span class="bb"><?php echo e($bed->label); ?></span></td>
            <td>
                <?php if($bed->status === 'occupied'): ?><span class="bdg bp">Occupied</span>
                <?php elseif($bed->status === 'cleaning'): ?><span class="bdg bo">Cleaning</span>
                <?php else: ?><span class="bdg" style="background:#e2e8f0;color:var(--navy)">Available</span><?php endif; ?>
            </td>
            <td>
                <?php if($bed->patient): ?>
                <div class="p-info"><div class="p-av"><?php echo e($bed->patient->initials); ?></div><?php echo e($bed->patient->name); ?></div>
                <?php else: ?> — <?php endif; ?>
            </td>
            <td class="td-act">
                <?php if($bed->status !== 'occupied'): ?>
                <button type="button" class="btn b-teal b-sm" onclick="openAssign(<?php echo e(json_encode($bed)); ?>)">Assign</button>
                <?php endif; ?>
                <?php if($bed->status === 'occupied'): ?>
                <form method="POST" action="<?php echo e(route('ward-beds.status', $bed->id)); ?>" style="display:inline"><?php echo csrf_field(); ?><input type="hidden" name="status" value="available"><button type="submit" class="btn b-ol b-sm">Free Bed</button></form>
                <?php endif; ?>
                <button type="button" class="btn b-ol b-sm" onclick="openEdit(<?php echo e(json_encode($bed)); ?>)">Edit</button>
                <form method="POST" action="<?php echo e(route('ward-beds.destroy', $bed->id)); ?>" style="display:inline" onsubmit="return confirm('Delete this bed?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button type="submit" class="btn b-dn b-sm">Delete</button></form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="4" style="text-align:center;padding:32px;color:var(--muted)">No beds configured. Add a bed to get started.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<div id="newBed" class="modal-overlay" onclick="if(event.target===this)this.classList.remove('active')">
    <div class="modal"><h3 style="margin-bottom:16px">Add Bed</h3>
    <form method="POST" action="<?php echo e(route('ward-beds.store')); ?>"><?php echo csrf_field(); ?>
        <div class="form-grid">
            <label class="full">Bed label<input name="label" placeholder="e.g. W1-A1" required></label>
            <label>Status<select name="status"><option value="available">Available</option><option value="cleaning">Cleaning</option></select></label>
        </div>
        <button type="submit" class="btn b-teal" style="margin-top:14px">Create Bed</button>
    </form></div>
</div>
<div id="editBed" class="modal-overlay" onclick="if(event.target===this)this.classList.remove('active')">
    <div class="modal"><h3 style="margin-bottom:16px">Edit Bed</h3>
    <form id="editBedForm" method="POST"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <div class="form-grid">
            <label class="full">Bed label<input name="label" id="edit_label" required></label>
            <label>Status<select name="status" id="edit_status" onchange="togglePatient(this.value)"><option value="available">Available</option><option value="occupied">Occupied</option><option value="cleaning">Cleaning</option></select></label>
            <label class="full" id="edit_patient_wrap" style="display:none">Patient<select name="patient_id" id="edit_patient_id"><option value="">—</option><?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($p->id); ?>"><?php echo e($p->patient_no); ?> — <?php echo e($p->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
        </div>
        <button type="submit" class="btn b-teal" style="margin-top:14px">Save Changes</button>
    </form></div>
</div>
<div id="assignBed" class="modal-overlay" onclick="if(event.target===this)this.classList.remove('active')">
    <div class="modal"><h3 style="margin-bottom:16px">Assign Patient</h3>
    <form id="assignForm" method="POST"><?php echo csrf_field(); ?>
        <label>Patient<select name="patient_id" required><?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($p->id); ?>"><?php echo e($p->patient_no); ?> — <?php echo e($p->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
        <button type="submit" class="btn b-teal" style="margin-top:14px">Assign</button>
    </form></div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
function openEdit(b) {
    document.getElementById('editBedForm').action = '<?php echo e(url('/ward-beds')); ?>/' + b.id;
    document.getElementById('edit_label').value = b.label;
    document.getElementById('edit_status').value = b.status;
    document.getElementById('edit_patient_id').value = b.patient_id || '';
    togglePatient(b.status);
    document.getElementById('editBed').classList.add('active');
}
function togglePatient(st) { document.getElementById('edit_patient_wrap').style.display = st === 'occupied' ? '' : 'none'; }
function openAssign(b) {
    document.getElementById('assignForm').action = '<?php echo e(url('/ward-beds')); ?>/' + b.id + '/assign';
    document.getElementById('assignBed').classList.add('active');
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.module', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\crest\OneDrive\Desktop\finalpit\finalpit\finalpit\resources\views/ward-beds/index.blade.php ENDPATH**/ ?>