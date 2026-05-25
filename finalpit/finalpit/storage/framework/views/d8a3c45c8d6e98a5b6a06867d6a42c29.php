
<?php $__env->startSection('title', 'Patient Register — Wellmeadows'); ?>
<?php $__env->startSection('page_title', 'Register and Update Patient'); ?>
<?php $__env->startSection('top_actions'); ?>
    <button type="button" class="btn b-teal" onclick="document.getElementById('newPatient').classList.add('active')">+ New Patient</button>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="stats">
    <div class="stat navy"><div class="stat-l">Total Patients</div><div class="stat-n"><?php echo e($totalPatients); ?></div><div class="stat-s">Active Patients</div></div>
    <div class="stat teal"><div class="stat-l">Registered This Month</div><div class="stat-n"><?php echo e($registeredThisMonth); ?></div><div class="stat-s">New Referrals</div></div>
    <div class="stat"><div class="stat-l">Out-Patients</div><div class="stat-n"><?php echo e($outPatients); ?></div><div class="stat-s">Clinic Appointment</div></div>
    <div class="stat outline"><div class="stat-l">In-Patients</div><div class="stat-n"><?php echo e($inPatients); ?></div><div class="stat-s">Currently Admitted</div></div>
</div>
<div class="card">
    <div class="card-hd">
        <div><div class="card-title">Patient Register</div><div class="card-sub">Search by name, patient no, or date</div></div>
        <input type="text" class="sinp" id="searchPatients" placeholder="Search patient…" onkeyup="filterPatients(this.value)">
    </div>
    <table class="tbl" id="patientTable">
        <thead><tr><th>Patient</th><th>Patient No.</th><th>DOB</th><th>Marital Status</th><th>Registered</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr data-search="<?php echo e(strtolower($p->name.' '.$p->patient_no)); ?>">
            <td><div class="p-info"><div class="p-av"><?php echo e($p->initials); ?></div><strong><?php echo e($p->name); ?></strong></div></td>
            <td class="mono"><?php echo e($p->patient_no); ?></td>
            <td><?php echo e($p->date_of_birth?->format('d M Y') ?? '—'); ?></td>
            <td><?php echo e($p->marital_status ?? '—'); ?></td>
            <td><?php echo e($p->date_registered?->format('d M Y') ?? '—'); ?></td>
            <td><span class="bdg <?php echo e($p->status === 'IN-PATIENT' ? 'bp' : 'bo'); ?>"><?php echo e($p->status); ?></span></td>
            <td class="td-act">
                <a href="<?php echo e(route('patients.edit', $p->id)); ?>" class="act-link act-edit">Edit →</a>
                <a href="<?php echo e(route('patients.medical', $p->id)); ?>" class="act-link act-rec">Records →</a>
                <form action="<?php echo e(route('patients.destroy', $p->id)); ?>" method="POST" style="display:inline" onsubmit="return confirm('Delete this patient record?')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="act-del">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="7" style="text-align:center;padding:40px;color:var(--muted)">No patients yet.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<div id="newPatient" class="modal-overlay" onclick="if(event.target===this)this.classList.remove('active')">
    <div class="modal">
        <h3 style="margin-bottom:16px;color:var(--navy)">New Patient</h3>
        <form method="POST" action="<?php echo e(route('patients.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-grid">
                <label>First name<input name="first_name" required></label>
                <label>Last name<input name="last_name" required></label>
                <label class="full">Address<input name="address" required></label>
                <label>Sex<select name="sex"><option>Male</option><option>Female</option></select></label>
                <label>Marital status<select name="marital_status"><option value="">—</option><option>Single</option><option>Married</option><option>Divorced</option><option>Widowed</option></select></label>
                <label>Date of birth<input type="date" name="date_of_birth" required></label>
                <label>Registered<input type="date" name="date_registered" value="<?php echo e(date('Y-m-d')); ?>" required></label>
                <label>Status<select name="status"><option>OUT-PATIENT</option><option>IN-PATIENT</option></select></label>
            </div>
            <div style="margin-top:16px;display:flex;gap:10px">
                <button type="submit" class="btn b-teal">Save Patient</button>
                <button type="button" class="btn b-ol" onclick="document.getElementById('newPatient').classList.remove('active')">Cancel</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
function filterPatients(q) {
    q = q.toLowerCase();
    document.querySelectorAll('#patientTable tbody tr[data-search]').forEach(tr => {
        tr.style.display = tr.dataset.search.includes(q) ? '' : 'none';
    });
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.hospital', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\pausa\Downloads\V.2\finalpit\finalpit\finalpit\resources\views/patients/index.blade.php ENDPATH**/ ?>