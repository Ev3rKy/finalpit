
<?php $__env->startSection('title', 'Admission & Discharge — Wellmeadows'); ?>
<?php $__env->startSection('page_title', 'Admission & Discharge'); ?>
<?php $__env->startSection('top_actions'); ?>
    <a href="<?php echo e(route('admission.index')); ?>" class="btn b-ol">All Records</a>
    <button type="button" class="btn b-teal" onclick="document.getElementById('newAdmission').classList.add('active')">+ New Admission</button>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="stats">
    <div class="stat navy"><div class="stat-l">Admissions Today</div><div class="stat-n"><?php echo e($admissionsToday); ?></div><div class="stat-s">New In-patients</div></div>
    <div class="stat teal"><div class="stat-l">Discharges Today</div><div class="stat-n"><?php echo e($dischargedToday); ?></div><div class="stat-s">Left Ward Today</div></div>
    <div class="stat"><div class="stat-l">Avg Length of Stay</div><div class="stat-n"><?php echo e($avgStayDays); ?></div><div class="stat-s">Across all Wards</div></div>
    <div class="stat outline"><div class="stat-l">Out-Patient Appts</div><div class="stat-n"><?php echo e($outPatients); ?></div><div class="stat-s">Today's Clinic</div></div>
</div>
<div class="grid-2">
    <div class="card">
        <div class="card-hd">
            <div class="card-title">In-patient Admissions</div>
            <span class="badge-count badge-active"><?php echo e($activeAdmissions->count()); ?> Active</span>
        </div>
        <table class="tbl">
            <thead><tr><th>Patient</th><th>Ward/Bed</th><th>Admitted</th><th>Action</th></tr></thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $activeAdmissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><div class="p-info"><div class="p-av"><?php echo e($a->patient?->initials ?? '?'); ?></div><?php echo e($a->patient?->name ?? '—'); ?></div></td>
                <td><?php echo e($a->ward_required ?? '—'); ?><?php echo e($a->bed_number ? ' / Bed '.$a->bed_number : ''); ?></td>
                <td><?php echo e($a->date_placed_ward?->format('d M Y') ?? $a->date_placed_waiting?->format('d M Y') ?? '—'); ?></td>
                <td><button type="button" class="btn b-teal b-sm" onclick="openDischarge(<?php echo e($a->id); ?>, '<?php echo e(addslashes($a->patient?->name ?? '')); ?>')">Discharge</button></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="4" style="color:var(--muted);padding:24px">No active admissions.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card">
        <div class="card-hd">
            <div class="card-title">Discharge Tracking</div>
            <span class="badge-count badge-pending"><?php echo e($pendingDischarges->count()); ?> Due This Week</span>
        </div>
        <table class="tbl">
            <thead><tr><th>Patient</th><th>Ward/Bed</th><th>Exp. Leave</th></tr></thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $pendingDischarges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($a->patient?->name ?? '—'); ?></td>
                <td><?php echo e($a->ward_required ?? '—'); ?></td>
                <td><?php echo e($a->date_expected_leave?->format('d M Y') ?? '—'); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="3" style="color:var(--muted);padding:24px">No pending discharges.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<div id="newAdmission" class="modal-overlay" onclick="if(event.target===this)this.classList.remove('active')">
    <div class="modal">
        <h3 style="margin-bottom:16px">New Admission</h3>
        <form method="POST" action="<?php echo e(route('admission.store')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="type" value="IN-PATIENT">
            <div class="form-grid">
                <label class="full">Patient<select name="patient_id" required>
                    <option value="">Select patient…</option>
                    <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($p->id); ?>"><?php echo e($p->patient_no); ?> — <?php echo e($p->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select></label>
                <label>Ward<select name="ward_required">
                    <option value="">Select ward…</option>
                    <?php $__empty_1 = true; $__currentLoopData = $billingWards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <option value="<?php echo e($w->name); ?>"><?php echo e($w->name); ?> (<?php echo e(max(0, $w->total_beds - $w->occupied_beds)); ?> vacant)</option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <option value="" disabled>Create wards in Billing → Wards first</option>
                    <?php endif; ?>
                </select></label>
                <label>Bed number<input name="bed_number"></label>
                <label>Date placed (ward)<input type="date" name="date_placed_ward" value="<?php echo e(date('Y-m-d')); ?>"></label>
                <label>Expected stay (days)<input type="number" name="expected_stay" min="1"></label>
                <label>Expected leave<input type="date" name="date_expected_leave"></label>
            </div>
            <button type="submit" class="btn b-teal" style="margin-top:14px">Admit Patient</button>
        </form>
    </div>
</div>
<div id="dischargeModal" class="modal-overlay" onclick="if(event.target===this)this.classList.remove('active')">
    <div class="modal">
        <h3 style="margin-bottom:8px">Discharge Patient</h3>
        <p id="dischargeName" style="color:var(--muted);font-size:12px;margin-bottom:16px"></p>
        <form id="dischargeForm" method="POST" action="">
            <?php echo csrf_field(); ?>
            <div class="form-grid">
                <label>Date left<input type="date" name="date_actually_left" value="<?php echo e(date('Y-m-d')); ?>" required></label>
                <label>Discharge type<select name="discharge_type"><option>Home</option><option>Transfer</option><option>Deceased</option><option>Other</option></select></label>
                <label class="full">Notes<textarea name="discharge_notes" rows="2"></textarea></label>
                <label class="full">Medications on discharge<input name="medications_on_discharge"></label>
            </div>
            <button type="submit" class="btn b-teal" style="margin-top:14px">Confirm Discharge</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
function openDischarge(id, name) {
    document.getElementById('dischargeForm').action = '<?php echo e(url('/admissions')); ?>/' + id + '/discharge';
    document.getElementById('dischargeName').textContent = name;
    document.getElementById('dischargeModal').classList.add('active');
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.hospital', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\crest\OneDrive\Desktop\finalpit\finalpit\finalpit\resources\views/patients/admission.blade.php ENDPATH**/ ?>