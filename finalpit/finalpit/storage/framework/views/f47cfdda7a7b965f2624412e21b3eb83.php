<?php $pfx = $prefix ?? ''; ?>
<div class="form-grid">
    <label class="full">Full name<input name="full_name" id="<?php echo e($pfx); ?>full_name" value="<?php echo e(old('full_name')); ?>" required></label>
    <label>Appointment date<input type="date" name="appointment_date" id="<?php echo e($pfx); ?>appointment_date" value="<?php echo e(old('appointment_date')); ?>" required></label>
    <label>Time<select name="appointment_time" id="<?php echo e($pfx); ?>appointment_time" required>
        <option value="">Select…</option>
        <?php $__currentLoopData = ['7:00AM','8:00AM','9:00AM','10:00AM','11:00AM','12:00PM','1:00PM','2:00PM','3:00PM','4:00PM','5:00PM']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($t); ?>"><?php echo e($t); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select></label>
    <label>Department<select name="medical_department" id="<?php echo e($pfx); ?>medical_department" required>
        <option value="">Select…</option>
        <?php $__currentLoopData = ['Neurology','Orthopedics','Dermatology','Cardiology','Ophthalmology','Emergency','ICU','General Medicine']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($d); ?>"><?php echo e($d); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select></label>
    <label>Doctor<select name="doctor" id="<?php echo e($pfx); ?>doctor" required>
        <option value="">Select…</option>
        <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($doc->full_name); ?>"><?php echo e($doc->full_name); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select></label>
    <label>Phone<input name="phone_no" id="<?php echo e($pfx); ?>phone_no" value="<?php echo e(old('phone_no')); ?>"></label>
    <label class="full">Address<input name="complete_address" id="<?php echo e($pfx); ?>complete_address" value="<?php echo e(old('complete_address')); ?>"></label>
</div>
<?php /**PATH C:\Users\crest\OneDrive\Desktop\finalpit\finalpit\finalpit\resources\views/appointments/partials/appointment-form.blade.php ENDPATH**/ ?>