
<?php $__env->startSection('title', 'Ward & Bed — Wellmeadows'); ?>
<?php $__env->startSection('page_title', 'Ward & Bed Management'); ?>
<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('ward-beds.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('top_actions'); ?>
<?php if($tab === 'wards' || $tab === 'beds'): ?>
<button type="button" class="btn b-ol" onclick="document.getElementById('createWard').classList.add('active')">+ Create Ward</button>
<?php endif; ?>
<?php if($tab === 'beds'): ?>
<button type="button" class="btn b-teal" onclick="document.getElementById('newBed').classList.add('active')" <?php echo e($wards->isEmpty() ? 'disabled title=Create a ward first' : ''); ?>>+ Add Bed</button>
<?php elseif($tab === 'assignments'): ?>
<button type="button" class="btn b-teal" onclick="openAssign()" <?php echo e($wardsForSelect->isEmpty() ? 'disabled title=Create a ward first' : ''); ?>>+ Assign Bed</button>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="stats">
    <div class="stat navy"><div class="stat-l">Total Beds</div><div class="stat-n"><?php echo e($totalBeds); ?></div><div class="stat-s"><?php echo e($wardCount); ?> Wards</div></div>
    <div class="stat teal"><div class="stat-l">Occupied</div><div class="stat-n"><?php echo e($occupiedCount); ?></div><div class="stat-s"><?php echo e($occupancyRate); ?>% Occupancy</div></div>
    <div class="stat"><div class="stat-l">Vacant</div><div class="stat-n"><?php echo e($vacant); ?></div><div class="stat-s">Available Now</div></div>
    <div class="stat outline"><div class="stat-l">Waiting List</div><div class="stat-n"><?php echo e($waitingList); ?></div><div class="stat-s">Across all Wards</div></div>
</div>

<?php if($tab === 'wards'): ?>
<?php if(request('from') === 'patients'): ?>
<div class="alert-ok" style="margin-bottom:16px">Opened from Patient Management. Wards created here are used for admissions and assignments across the hospital. <a href="<?php echo e(route('admission.index')); ?>" class="act-link">← Return to Admissions</a></div>
<?php endif; ?>
<div class="card">
    <div class="card-hd">
        <div>
            <div class="card-title">Hospital Wards</div>
            <div class="card-sub">Maintain ward details — name, type, and bed capacity</div>
        </div>
    </div>
    <table class="tbl">
        <thead><tr><th>No.</th><th>Name</th><th>Type</th><th>Location</th><th>Capacity</th><th>Beds in Matrix</th><th>Actions</th></tr></thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $wards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php $bedsInWard = $beds->where('ward_number', $w->ward_number)->count(); ?>
        <tr>
            <td class="mono"><?php echo e($w->ward_number); ?></td>
            <td><strong><?php echo e($w->ward_name); ?></strong></td>
            <td><?php echo e($w->ward_type ?? '—'); ?></td>
            <td><?php echo e($w->location ?? '—'); ?></td>
            <td><?php echo e($w->total_beds); ?></td>
            <td><?php echo e($bedsInWard); ?></td>
            <td class="td-act">
                <a href="<?php echo e(route('ward-beds.index', ['tab' => 'beds', 'ward' => $w->ward_number])); ?>" class="btn b-ol b-sm">View Beds</a>
                <form method="POST" action="<?php echo e(route('ward-beds.wards.destroy', $w->ward_number)); ?>" style="display:inline" onsubmit="return confirm('Delete this ward?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn b-dn b-sm">Delete</button></form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="7" style="text-align:center;padding:32px;color:var(--muted)">No wards defined. Click <strong>+ Create Ward</strong> above.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<?php if($tab === 'beds'): ?>
<?php if($wards->isEmpty()): ?>
<div class="alert-err" style="background:#fffbeb;color:#92400e;border-color:#fde68a">Create a ward first before managing beds.</div>
<?php endif; ?>
<div class="card">
    <div class="card-hd">
        <div><div class="card-title">Bed Allocation Matrix</div><div class="card-sub">Manage bed availability and assign patients</div></div>
        <form method="GET" action="<?php echo e(route('ward-beds.index')); ?>" style="display:flex;gap:8px;flex-wrap:wrap">
            <input type="hidden" name="tab" value="beds">
            <select name="ward" class="sinp" onchange="this.form.submit()">
                <option value="">All wards</option>
                <?php $__currentLoopData = $wards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($w->ward_number); ?>" <?php echo e(($wardFilter ?? '') == $w->ward_number ? 'selected' : ''); ?>>Ward <?php echo e($w->ward_number); ?> — <?php echo e($w->ward_name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <input type="text" name="search" class="sinp" value="<?php echo e($search ?? ''); ?>" placeholder="Search bed or patient…">
        </form>
    </div>
    <table class="tbl">
        <thead><tr><th>Bed</th><th>Ward</th><th>Status</th><th>Patient</th><th>Actions</th></tr></thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $beds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bed): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><span class="bb"><?php echo e($bed->label); ?></span></td>
            <td><?php if($bed->ward): ?>Ward <?php echo e($bed->ward->ward_number); ?> — <?php echo e($bed->ward->ward_name); ?><?php else: ?> — <?php endif; ?></td>
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
                <button type="button" class="btn b-teal b-sm" onclick="openAssignBed(<?php echo e(json_encode($bed)); ?>)">Assign</button>
                <?php endif; ?>
                <?php if($bed->status === 'occupied'): ?>
                <form method="POST" action="<?php echo e(route('ward-beds.status', $bed->id)); ?>" style="display:inline"><?php echo csrf_field(); ?><input type="hidden" name="status" value="available"><button type="submit" class="btn b-ol b-sm">Free Bed</button></form>
                <?php endif; ?>
                <button type="button" class="btn b-ol b-sm" onclick="openEdit(<?php echo e(json_encode($bed)); ?>)">Edit</button>
                <form method="POST" action="<?php echo e(route('ward-beds.destroy', $bed->id)); ?>" style="display:inline" onsubmit="return confirm('Delete this bed?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button type="submit" class="btn b-dn b-sm">Delete</button></form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="5" style="text-align:center;padding:32px;color:var(--muted)">No beds configured. Add a ward, then click + Add Bed.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<?php if($tab === 'assignments'): ?>
<div class="card">
    <div class="card-hd">
        <div><div class="card-title">Patient Allocation Report</div><div class="card-sub">Assign beds to admitted patients</div></div>
        <form method="GET" action="<?php echo e(route('ward-beds.index')); ?>">
            <input type="hidden" name="tab" value="assignments">
            <input type="text" name="search" class="sinp" value="<?php echo e($search ?? ''); ?>" placeholder="Search patient…">
        </form>
    </div>
    <table class="tbl">
        <thead><tr><th>Patient</th><th>Patient No.</th><th>Ward</th><th>Ward No.</th><th>Bed</th><th>Date Placed</th><th>Expected Stay</th><th>Expected Leave</th></tr></thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><div class="p-info"><div class="p-av"><?php echo e($r->patient?->initials); ?></div><strong><?php echo e($r->patient?->name); ?></strong></div></td>
            <td class="mono"><?php echo e($r->patient?->patient_no); ?></td>
            <td><?php echo e($r->ward_name ?? '—'); ?></td>
            <td><?php echo e($r->ward_number ?? '—'); ?></td>
            <td><?php if($r->bed_number): ?><span class="bb"><?php echo e($r->bed_number); ?></span><?php else: ?> — <?php endif; ?></td>
            <td><?php echo e($r->date_placed?->format('d M Y') ?? '—'); ?></td>
            <td><?php echo e($r->expected_stay ? $r->expected_stay.'d' : '—'); ?></td>
            <td><?php echo e($r->date_expected_leave?->format('d M Y') ?? '—'); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="8" style="text-align:center;padding:32px;color:var(--muted)">No active assignments. Use + Assign Bed to place a patient.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>


<div id="createWard" class="modal-overlay" onclick="if(event.target===this)this.classList.remove('active')">
    <div class="modal">
        <h3 style="margin-bottom:16px">Create Ward</h3>
        <form method="POST" action="<?php echo e(route('ward-beds.wards.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-grid">
                <label>Ward number<input type="number" name="ward_number" min="1" required placeholder="e.g. 1"></label>
                <label>Ward name<input name="ward_name" required placeholder="e.g. General Ward A"></label>
                <label>Ward type<select name="ward_type">
                    <option value="">—</option>
                    <?php $__currentLoopData = ['General','ICU','Pediatric','Maternity','Surgical']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($t); ?>"><?php echo e($t); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select></label>
                <label>Location<input name="location" placeholder="Block A"></label>
                <label>Bed capacity<input type="number" name="total_beds" min="1" value="20" required></label>
                <label>Extension<input name="tel_extn" placeholder="Optional"></label>
            </div>
            <div style="margin-top:14px;display:flex;gap:10px">
                <button type="submit" class="btn b-teal">Save Ward</button>
                <button type="button" class="btn b-ol" onclick="document.getElementById('createWard').classList.remove('active')">Cancel</button>
            </div>
        </form>
    </div>
</div>


<div id="newBed" class="modal-overlay" onclick="if(event.target===this)this.classList.remove('active')">
    <div class="modal"><h3 style="margin-bottom:16px">Add Bed</h3>
    <form method="POST" action="<?php echo e(route('ward-beds.store')); ?>"><?php echo csrf_field(); ?>
        <div class="form-grid">
            <label class="full">Ward<select name="ward_number" required>
                <option value="">Select ward…</option>
                <?php $__currentLoopData = $wards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($w->ward_number); ?>" <?php echo e(($wardFilter ?? '') == $w->ward_number ? 'selected' : ''); ?>>Ward <?php echo e($w->ward_number); ?> — <?php echo e($w->ward_name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select></label>
            <label class="full">Bed label<input name="label" placeholder="e.g. A1 or W1-A1" required></label>
            <label>Status<select name="status"><option value="available">Available</option><option value="cleaning">Cleaning</option></select></label>
        </div>
        <button type="submit" class="btn b-teal" style="margin-top:14px">Create Bed</button>
    </form></div>
</div>


<div id="editBed" class="modal-overlay" onclick="if(event.target===this)this.classList.remove('active')">
    <div class="modal"><h3 style="margin-bottom:16px">Edit Bed</h3>
    <form id="editBedForm" method="POST"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <div class="form-grid">
            <label class="full">Ward<select name="ward_number" id="edit_ward_number" required>
                <?php $__currentLoopData = $wards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($w->ward_number); ?>">Ward <?php echo e($w->ward_number); ?> — <?php echo e($w->ward_name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select></label>
            <label class="full">Bed label<input name="label" id="edit_label" required></label>
            <label>Status<select name="status" id="edit_status" onchange="togglePatient(this.value)"><option value="available">Available</option><option value="occupied">Occupied</option><option value="cleaning">Cleaning</option></select></label>
            <label class="full" id="edit_patient_wrap" style="display:none">Patient<select name="patient_id" id="edit_patient_id"><option value="">—</option><?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($p->id); ?>"><?php echo e($p->patient_no); ?> — <?php echo e($p->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
        </div>
        <button type="submit" class="btn b-teal" style="margin-top:14px">Save Changes</button>
    </form></div>
</div>


<div id="assignBedQuick" class="modal-overlay" onclick="if(event.target===this)this.classList.remove('active')">
    <div class="modal"><h3 style="margin-bottom:16px">Assign Patient to Bed</h3>
    <form id="assignBedQuickForm" method="POST"><?php echo csrf_field(); ?>
        <label>Patient<select name="patient_id" required><?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($p->id); ?>"><?php echo e($p->patient_no); ?> — <?php echo e($p->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
        <button type="submit" class="btn b-teal" style="margin-top:14px">Assign</button>
    </form></div>
</div>


<div id="assignBed" class="modal-overlay" onclick="if(event.target===this)this.classList.remove('active')">
    <div class="modal">
        <h3 style="margin-bottom:16px">Assign Bed to Patient</h3>
        <form method="POST" action="<?php echo e(route('ward-beds.assignments.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-grid">
                <label class="full">Patient<select name="patient_id" required>
                    <option value="">Select patient…</option>
                    <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($p->id); ?>"><?php echo e($p->patient_no); ?> — <?php echo e($p->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select></label>
                <label>Ward<select name="ward_name" required onchange="onWardSelect(this)">
                    <option value="">Select ward…</option>
                    <?php $__currentLoopData = $wardsForSelect; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($w->billing_name); ?>" data-ward-number="<?php echo e($w->ward_number); ?>">
                        Ward <?php echo e($w->ward_number); ?> — <?php echo e($w->ward_name); ?> (<?php echo e($w->vacant); ?> vacant)
                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select></label>
                <label>Ward number<input name="ward_number" id="assign_ward_number" readonly></label>
                <label>Bed number<input name="bed_number" required placeholder="e.g. W1-A1"></label>
                <label>Date placed<input type="date" name="date_placed" value="<?php echo e(date('Y-m-d')); ?>"></label>
                <label>Expected stay (days)<input type="number" name="expected_stay" min="1"></label>
                <label>Expected leave<input type="date" name="date_expected_leave"></label>
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
function onWardSelect(sel) {
    const opt = sel.options[sel.selectedIndex];
    document.getElementById('assign_ward_number').value = opt.dataset.wardNumber || '';
}
function openAssign() {
    document.getElementById('assignBed').classList.add('active');
}
function openEdit(b) {
    document.getElementById('editBedForm').action = '<?php echo e(url('/ward-beds')); ?>/' + b.id;
    document.getElementById('edit_ward_number').value = b.ward_number || '';
    document.getElementById('edit_label').value = b.label;
    document.getElementById('edit_status').value = b.status;
    document.getElementById('edit_patient_id').value = b.patient_id || '';
    togglePatient(b.status);
    document.getElementById('editBed').classList.add('active');
}
function togglePatient(st) { document.getElementById('edit_patient_wrap').style.display = st === 'occupied' ? '' : 'none'; }
function openAssignBed(b) {
    document.getElementById('assignBedQuickForm').action = '<?php echo e(url('/ward-beds')); ?>/' + b.id + '/assign';
    document.getElementById('assignBedQuick').classList.add('active');
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.module', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\pausa\Downloads\V.2\finalpit\finalpit\finalpit\resources\views/ward-beds/index.blade.php ENDPATH**/ ?>