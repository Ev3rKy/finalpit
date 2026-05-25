<div class="form-grid">
    <label class="full">Patient<select name="patient_full_name" required>
        <option value="">Select patient…</option>
        <?php $__currentLoopData = ($patients ?? collect()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($p->name); ?>" <?php echo e(old('patient_full_name') === $p->name ? 'selected' : ''); ?>><?php echo e($p->patient_no); ?> — <?php echo e($p->name); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php if(($patients ?? collect())->isEmpty()): ?>
        <option value="" disabled>Register patients in Patient Management first</option>
        <?php endif; ?>
    </select></label>
    <label>Treatment type<input name="treatment_type" value="<?php echo e(old('treatment_type')); ?>" placeholder="e.g. Post-op care" required></label>
    <label>Staff role<select name="staff_type" onchange="updateStaffList(this.value,'')">
        <option value="doctor">Doctor</option>
        <option value="nurse">Nurse</option>
    </select></label>
    <label>Assigned staff<select name="assigned_staff" id="assigned_staff_select" required>
        <option value="">Select…</option>
        <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($d->full_name); ?>" data-role="doctor"><?php echo e($d->display_name); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select></label>
    <?php if(!empty($edit)): ?>
    <label class="full" style="flex-direction:row;align-items:center;gap:8px;text-transform:none">
        <input type="checkbox" name="is_completed" value="1" style="width:auto"> Mark as completed
    </label>
    <?php endif; ?>
</div>
<?php if($doctors->isEmpty() && $nurses->isEmpty()): ?>
<p style="font-size:11px;color:var(--muted);margin-top:8px">No clinical staff found. Add staff with position <strong>Doctor</strong>, <strong>Consultant</strong>, or <strong>Nurse</strong> in <a href="<?php echo e(route('staff.index')); ?>" class="act-link">Staff &amp; Departments</a>.</p>
<?php endif; ?>
<?php /**PATH C:\Users\pausa\Downloads\V.2\finalpit\finalpit\finalpit\resources\views/appointments/partials/assign-form.blade.php ENDPATH**/ ?>