

<?php $__env->startSection('title', 'Add Staff — Wellmeadows'); ?>
<?php $__env->startSection('top_title', 'Add Staff Member'); ?>
<?php $__env->startSection('top_sub', 'STAFF REGISTRATION'); ?>

<?php $__env->startSection('content'); ?>
<div class="bc">
    <a href="<?php echo e(route('staff.index')); ?>">Staff Directory</a>
    <span>›</span><span>Add New Staff</span>
</div>

<div class="sh">
    <div>
        <div class="sh-title">Add Staff Member</div>
        <div class="sh-sub">Fields marked <span class="req">*</span> are required</div>
    </div>
</div>

<div class="card">
    <div class="card-hd"><div class="card-title">Staff Registration Form</div></div>
    <div class="card-body">
        <form action="<?php echo e(route('staff.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="fg">

                <?php if($errors->any()): ?>
                <div class="alert-err" style="grid-column:1/-1">
                    <strong>Please fix the following:</strong>
                    <ul style="margin-top:6px;padding-left:16px">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <?php endif; ?>

                <div class="fsec">Personal Information</div>

                <div class="fgp">
                    <label>Staff Number <span class="req">*</span></label>
                    <input type="text" name="staff_number" value="<?php echo e(old('staff_number')); ?>" placeholder="e.g. S011">
                    <?php $__errorArgs = ['staff_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="err-msg"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="fgp">
                    <label>First Name <span class="req">*</span></label>
                    <input type="text" name="first_name" value="<?php echo e(old('first_name')); ?>" placeholder="First name">
                    <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="err-msg"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="fgp">
                    <label>Last Name <span class="req">*</span></label>
                    <input type="text" name="last_name" value="<?php echo e(old('last_name')); ?>" placeholder="Last name">
                    <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="err-msg"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="fgp full">
                    <label>Full Address <span class="req">*</span></label>
                    <input type="text" name="address" value="<?php echo e(old('address')); ?>" placeholder="Street, City, Postcode">
                    <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="err-msg"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="fgp">
                    <label>Telephone Number</label>
                    <input type="text" name="tel_no" value="<?php echo e(old('tel_no')); ?>" placeholder="e.g. 0131-334-5677">
                </div>
                <div class="fgp">
                    <label>Date of Birth <span class="req">*</span></label>
                    <input type="date" name="dob" value="<?php echo e(old('dob')); ?>">
                    <?php $__errorArgs = ['dob'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="err-msg"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="fgp">
                    <label>Sex <span class="req">*</span></label>
                    <select name="sex">
                        <option value="">-- Select --</option>
                        <option value="M" <?php echo e(old('sex')=='M'?'selected':''); ?>>Male</option>
                        <option value="F" <?php echo e(old('sex')=='F'?'selected':''); ?>>Female</option>
                    </select>
                    <?php $__errorArgs = ['sex'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="err-msg"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="fgp">
                    <label>NIN <span class="req">*</span></label>
                    <input type="text" name="nin" value="<?php echo e(old('nin')); ?>" placeholder="e.g. WB123423D">
                    <?php $__errorArgs = ['nin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="err-msg"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="fsec">Employment Details</div>

                <div class="fgp">
                    <label>Position <span class="req">*</span></label>
                    <select name="position">
                        <option value="">-- Select --</option>
                        <?php $__currentLoopData = ['Charge Nurse','Staff Nurse','Nurse','Consultant','Doctor','Auxiliary']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($p); ?>" <?php echo e(old('position')==$p?'selected':''); ?>><?php echo e($p); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="err-msg"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="fgp">
                    <label>Current Salary <span class="req">*</span></label>
                    <input type="number" name="current_salary" value="<?php echo e(old('current_salary')); ?>" placeholder="e.g. 18760" step="0.01">
                    <?php $__errorArgs = ['current_salary'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="err-msg"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="fgp">
                    <label>Salary Scale</label>
                    <input type="text" name="salary_scale" value="<?php echo e(old('salary_scale')); ?>" placeholder="e.g. 1C">
                </div>
                <div class="fgp">
                    <label>Hours per Week</label>
                    <input type="number" name="hours_per_week" value="<?php echo e(old('hours_per_week')); ?>" placeholder="e.g. 37.5" step="0.5">
                </div>
                <div class="fgp">
                    <label>Contract Type <span class="req">*</span></label>
                    <select name="contract_type">
                        <option value="">-- Select --</option>
                        <option value="Permanent" <?php echo e(old('contract_type')=='Permanent'?'selected':''); ?>>Permanent</option>
                        <option value="Temporary" <?php echo e(old('contract_type')=='Temporary'?'selected':''); ?>>Temporary</option>
                    </select>
                    <?php $__errorArgs = ['contract_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="err-msg"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="fgp">
                    <label>Payment Type</label>
                    <select name="payment_type">
                        <option value="">-- Select --</option>
                        <option value="Weekly" <?php echo e(old('payment_type')=='Weekly'?'selected':''); ?>>Weekly</option>
                        <option value="Monthly" <?php echo e(old('payment_type')=='Monthly'?'selected':''); ?>>Monthly</option>
                    </select>
                </div>

                <div class="fa">
                    <a href="<?php echo e(route('staff.index')); ?>" class="btn b-ol">Cancel</a>
                    <button type="submit" class="btn b-nv">+ Save Staff Member</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.staff', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\pausa\Downloads\V.2\finalpit\finalpit\finalpit\resources\views/staff/create.blade.php ENDPATH**/ ?>