
<?php $__env->startSection('title', 'Edit Patient — Wellmeadows'); ?>
<?php $__env->startSection('page_title', 'Edit Patient Profile'); ?>
<?php $__env->startSection('top_actions'); ?>
    <a href="<?php echo e(route('patients.index')); ?>" class="btn b-ol">← Back to Register</a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="card" style="padding:24px">
    <form method="POST" action="<?php echo e(route('patients.update', $patient->id)); ?>">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <div class="form-grid">
            <label>First name<input name="first_name" value="<?php echo e($patient->first_name); ?>" required></label>
            <label>Last name<input name="last_name" value="<?php echo e($patient->last_name); ?>" required></label>
            <label class="full">Address<input name="address" value="<?php echo e($patient->address); ?>" required></label>
            <label>Sex<select name="sex"><option <?php echo e($patient->sex=='Male'?'selected':''); ?>>Male</option><option <?php echo e($patient->sex=='Female'?'selected':''); ?>>Female</option></select></label>
            <label>Marital status<select name="marital_status">
                <?php $__currentLoopData = ['','Single','Married','Divorced','Widowed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($ms); ?>" <?php echo e(($patient->marital_status ?? '') === $ms ? 'selected' : ''); ?>><?php echo e($ms ?: '—'); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select></label>
            <label>Date of birth<input type="date" name="date_of_birth" value="<?php echo e($patient->date_of_birth?->format('Y-m-d')); ?>" required></label>
            <label>Registered<input type="date" name="date_registered" value="<?php echo e($patient->date_registered?->format('Y-m-d')); ?>" required></label>
            <label>Status<select name="status"><option <?php echo e($patient->status=='OUT-PATIENT'?'selected':''); ?>>OUT-PATIENT</option><option <?php echo e($patient->status=='IN-PATIENT'?'selected':''); ?>>IN-PATIENT</option></select></label>
        </div>
        <button type="submit" class="btn b-teal" style="margin-top:16px">Update Patient</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.hospital', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\pausa\Downloads\V.2\finalpit\finalpit\finalpit\resources\views/patients/edit.blade.php ENDPATH**/ ?>