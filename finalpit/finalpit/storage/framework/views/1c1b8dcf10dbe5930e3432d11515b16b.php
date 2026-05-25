
<?php $__env->startSection('title', 'Ward & Bed — Wellmeadows'); ?>
<?php $__env->startSection('page_title', 'Ward & Bed Assignment'); ?>
<?php $__env->startSection('top_actions'); ?>
    <button type="button" class="btn b-teal" onclick="document.getElementById('assignBed').classList.add('active')">+ Assign Bed</button>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php $occupancy = $totalBeds > 0 ? round(($occupied / $totalBeds) * 100) : 0; ?>
<div class="stats">
    <div class="stat navy"><div class="stat-l">Total Beds</div><div class="stat-n"><?php echo e($totalBeds); ?></div><div class="stat-s"><?php echo e($wardCount); ?> Wards</div></div>
    <div class="stat teal"><div class="stat-l">Occupied</div><div class="stat-n"><?php echo e($occupied); ?></div><div class="stat-s"><?php echo e($occupancy); ?>% Occupancy</div></div>
    <div class="stat"><div class="stat-l">Vacant</div><div class="stat-n"><?php echo e($vacant); ?></div><div class="stat-s">Available Now</div></div>
    <div class="stat outline"><div class="stat-l">Waiting List</div><div class="stat-n"><?php echo e($waitingList); ?></div><div class="stat-s">Across all Wards</div></div>
</div>
<div class="card">
    <div class="card-hd">
        <div class="card-title">Patient Allocation Report</div>
        <form method="GET" action="<?php echo e(route('ward.index')); ?>"><input type="text" name="search" class="sinp" value="<?php echo e($search ?? ''); ?>" placeholder="Search patient…"></form>
    </div>
    <table class="tbl">
        <thead><tr><th>Patient</th><th>Patient No.</th><th>Ward</th><th>Bed</th><th>Date Placed</th><th>Expected Stay</th><th>Expected Leave</th><th>Date Left</th><th>Action</th></tr></thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><div class="p-info"><div class="p-av"><?php echo e($r->patient?->initials); ?></div><strong><?php echo e($r->patient?->name); ?></strong></div></td>
            <td class="mono"><?php echo e($r->patient?->patient_no); ?></td>
            <td><?php echo e($r->ward_name ?? $r->ward_number ?? '—'); ?></td>
            <td><?php if($r->bed_number): ?><span class="bb">BED <?php echo e($r->bed_number); ?></span><?php else: ?> — <?php endif; ?></td>
            <td><?php echo e($r->date_placed?->format('d M Y') ?? '—'); ?></td>
            <td><?php echo e($r->expected_stay ? $r->expected_stay.'d' : '—'); ?></td>
            <td><?php echo e($r->date_expected_leave?->format('d M Y') ?? '—'); ?></td>
            <td><?php echo e($r->date_actually_left?->format('d M Y') ?? '—'); ?></td>
            <td><button type="button" class="btn b-teal b-sm" onclick="editWard(<?php echo e(json_encode($r)); ?>)">Edit</button></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="9" style="text-align:center;padding:32px;color:var(--muted)">No ward assignments yet. Use + Assign Bed to place a patient.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<div id="assignBed" class="modal-overlay" onclick="if(event.target===this)this.classList.remove('active')">
    <div class="modal">
        <h3 style="margin-bottom:16px" id="wardModalTitle">Assign Bed</h3>
        <form method="POST" action="<?php echo e(route('ward.store')); ?>" id="wardForm">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="record_id" id="record_id">
            <div class="form-grid">
                <label class="full">Patient<select name="patient_id" id="patient_id" required>
                    <option value="">Select patient…</option>
                    <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($p->id); ?>"><?php echo e($p->patient_no); ?> — <?php echo e($p->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select></label>
                <label>Ward<select name="ward_name" id="ward_name" required>
                    <option value="">Select ward…</option>
                    <?php $__currentLoopData = $billingWards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($w->name); ?>"><?php echo e($w->name); ?> (<?php echo e(max(0, $w->total_beds - $w->occupied_beds)); ?> vacant)</option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select></label>
                <label>Ward number<input name="ward_number" id="ward_number"></label>
                <label>Bed number<input name="bed_number" id="bed_number" required></label>
                <label>Date placed<input type="date" name="date_placed" id="date_placed" value="<?php echo e(date('Y-m-d')); ?>"></label>
                <label>Expected stay (days)<input type="number" name="expected_stay" id="expected_stay"></label>
                <label>Expected leave<input type="date" name="date_expected_leave" id="date_expected_leave"></label>
            </div>
            <div style="margin-top:14px;display:flex;gap:10px">
                <button type="submit" class="btn b-teal">Save Assignment</button>
                <button type="button" class="btn b-ol" onclick="document.getElementById('assignBed').classList.remove('active')">Cancel</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
function editWard(r) {
    document.getElementById('wardModalTitle').textContent = 'Edit Ward Assignment';
    document.getElementById('patient_id').value = r.patient_id;
    document.getElementById('ward_name').value = r.ward_name || '';
    document.getElementById('ward_number').value = r.ward_number || '';
    document.getElementById('bed_number').value = r.bed_number || '';
    document.getElementById('date_placed').value = r.date_placed ? r.date_placed.substring(0,10) : '';
    document.getElementById('expected_stay').value = r.expected_stay || '';
    document.getElementById('date_expected_leave').value = r.date_expected_leave ? r.date_expected_leave.substring(0,10) : '';
    document.getElementById('assignBed').classList.add('active');
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.hospital', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\crest\OneDrive\Desktop\finalpit\finalpit\finalpit\resources\views/patients/ward.blade.php ENDPATH**/ ?>