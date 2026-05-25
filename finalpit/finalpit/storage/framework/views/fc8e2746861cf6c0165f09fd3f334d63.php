
<?php $__env->startSection('title', 'Medical Records — <?php echo e($patient->name); ?>'); ?>
<?php $__env->startSection('page_title', 'Medical Records'); ?>
<?php $__env->startSection('top_actions'); ?>
    <a href="<?php echo e(route('medical.index')); ?>" class="btn b-ol">Back to Patients</a>
    <button type="button" class="btn b-teal" onclick="document.getElementById('addMed').classList.add('active')">+ Add Entry</button>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="pb">
    <div class="pav"><?php echo e($patient->initials); ?></div>
    <div>
        <div class="pn"><?php echo e($patient->name); ?></div>
        <div class="pr">Patient No. <?php echo e($patient->patient_no); ?></div>
        <div class="pm">
            <div class="pmi"><strong>Sex</strong><?php echo e($patient->sex); ?></div>
            <div class="pmi"><strong>Marital Status</strong><?php echo e($patient->marital_status ?? '—'); ?></div>
            <div class="pmi"><strong>Date of Birth</strong><?php echo e($patient->date_of_birth?->format('d M Y')); ?></div>
        </div>
    </div>
    <div style="margin-left:auto"><a href="<?php echo e(route('patients.edit', $patient->id)); ?>" class="btn b-ol">Edit Profile</a></div>
</div>
<div class="card">
    <div class="card-hd">
        <div><div class="card-title">Patient Medication Form</div><div class="card-sub"><?php echo e($patient->name); ?> · <?php echo e($patient->patient_no); ?></div></div>
    </div>
    <table class="tbl">
        <thead><tr><th>Drug Number</th><th>Name</th><th>Description</th><th>Dosage</th><th>Method</th><th>Units/Day</th><th>Start Date</th><th>Finish Date</th><th>Action</th></tr></thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $medications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td class="mono"><?php echo e($m->drug_number); ?></td>
            <td><?php echo e($m->drug_name); ?></td>
            <td><?php echo e($m->description ?? '—'); ?></td>
            <td><?php echo e($m->dosage ?? '—'); ?></td>
            <td><?php echo e($m->method_of_admin ?? '—'); ?></td>
            <td><?php echo e($m->units_per_day ?? '—'); ?></td>
            <td><?php echo e($m->start_date?->format('d M Y')); ?></td>
            <td><?php echo e($m->finish_date?->format('d M Y') ?? '—'); ?></td>
            <td>
                <form action="<?php echo e(route('medications.destroy', $m->id)); ?>" method="POST" onsubmit="return confirm('Remove this medication?')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="act-del">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="9" style="text-align:center;padding:32px;color:var(--muted)">No medication records yet.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<div id="addMed" class="modal-overlay" onclick="if(event.target===this)this.classList.remove('active')">
    <div class="modal" style="max-width:640px">
        <h3 style="margin-bottom:16px">Add Medication</h3>
        <form method="POST" action="<?php echo e(route('patients.medical.store')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="patient_id" value="<?php echo e($patient->id); ?>">
            <div class="form-grid">
                <label>Drug number<input name="drug_number" required></label>
                <label>Drug name<input name="drug_name" required></label>
                <label>Description<input name="description"></label>
                <label>Dosage<input name="dosage"></label>
                <label>Method of admin<input name="method_of_admin"></label>
                <label>Units per day<input type="number" name="units_per_day" min="0"></label>
                <label>Start date<input type="date" name="start_date" value="<?php echo e(date('Y-m-d')); ?>" required></label>
                <label>Finish date<input type="date" name="finish_date"></label>
            </div>
            <button type="submit" class="btn b-teal" style="margin-top:14px">Add Medication</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.hospital', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\crest\OneDrive\Desktop\finalpit\finalpit\finalpit\resources\views/patients/medical.blade.php ENDPATH**/ ?>