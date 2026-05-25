<?php $pfx = isset($prefix) ? $prefix : ''; ?>
<div class="form-grid">
    <label class="full">Patient full name<input name="patient_full_name" value="<?php echo e(old('patient_full_name')); ?>" required></label>
    <label>Doctor<select name="doctor" required>
        <option value="">Select…</option>
        <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($doc->full_name); ?>"><?php echo e($doc->full_name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select></label>
    <label>Procedure<select name="procedure" required>
        <option value="">Select…</option>
        <?php $__currentLoopData = ['Consultation','Surgery','Lab Test','X-Ray','Physical Therapy','Emergency Care','Follow-up']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($p); ?>"><?php echo e($p); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select></label>
    <label>Treatment date &amp; time<input type="datetime-local" name="treatment_datetime" value="<?php echo e(old('treatment_datetime', now()->format('Y-m-d\TH:i'))); ?>" required></label>
    <label>BP<input name="bp" placeholder="120/80"></label>
    <label>Temperature<input name="temperature" placeholder="36.5°C"></label>
    <label>SPO2<input name="spo2" placeholder="98%"></label>
    <label class="full">Medical notes<textarea name="medical_notes" rows="2"><?php echo e(old('medical_notes')); ?></textarea></label>
</div>
<?php /**PATH C:\Users\pausa\Downloads\V.2\finalpit\finalpit\finalpit\resources\views/appointments/partials/treatment-form.blade.php ENDPATH**/ ?>