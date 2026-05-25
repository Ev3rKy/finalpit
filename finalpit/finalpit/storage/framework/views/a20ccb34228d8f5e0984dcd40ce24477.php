<div class="form-grid">
    <label class="full">Patient name<input name="patient_full_name" value="<?php echo e(old('patient_full_name')); ?>" required></label>
    <label>Treatment type<input name="treatment_type" value="<?php echo e(old('treatment_type')); ?>" placeholder="e.g. Post-op care" required></label>
    <label>Staff role<select name="staff_type" onchange="updateStaffList(this.value,'')">
        <option value="doctor">Doctor</option>
        <option value="nurse">Nurse</option>
    </select></label>
    <label>Assigned staff<select name="assigned_staff" required>
        <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($d->full_name); ?>"><?php echo e($d->full_name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select></label>
    <?php if(!empty($edit)): ?>
    <label class="full" style="flex-direction:row;align-items:center;gap:8px;text-transform:none">
        <input type="checkbox" name="is_completed" value="1" style="width:auto"> Mark as completed
    </label>
    <?php endif; ?>
</div>
<script>
function updateStaffList(type, selected) {
    const sel = document.querySelector('[name="assigned_staff"]');
    if (!sel) return;
    const doctors = <?php echo json_encode($doctors->pluck('full_name'), 15, 512) ?>;
    const nurses = <?php echo json_encode($nurses->pluck('full_name'), 15, 512) ?>;
    const list = type === 'nurse' ? nurses : doctors;
    sel.innerHTML = '<option value="">Select…</option>' + list.map(n => '<option value="'+n+'"'+(n===selected?' selected':'')+'>'+n+'</option>').join('');
}
</script>
<?php /**PATH C:\Users\crest\OneDrive\Desktop\finalpit\finalpit\finalpit\resources\views/appointments/partials/assign-form.blade.php ENDPATH**/ ?>