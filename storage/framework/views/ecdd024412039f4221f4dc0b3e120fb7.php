<?php $__env->startSection('page-title', 'Edit Bill'); ?>

<?php $__env->startSection('content'); ?>
<div class="overlay">
  <div class="modal">
    <div class="modal-title">Edit bill</div>
    <div class="muted" style="font-size:11px;margin-bottom:16px"><?php echo e($bill->bill_no); ?> · Created <?php echo e($bill->created_at->format('F d, Y')); ?></div>

    <form method="POST" action="<?php echo e(route('bills.update', $bill)); ?>">
      <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

      <div class="field">
        <label>Patient full name *</label>
        <input type="text" name="patient_name" value="<?php echo e(old('patient_name', $bill->patient_name)); ?>" required>
        <?php $__errorArgs = ['patient_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="field-row">
        <div class="field">
          <label>Patient ID *</label>
          <input type="text" name="patient_id" value="<?php echo e(old('patient_id', $bill->patient_id)); ?>" required>
          <?php $__errorArgs = ['patient_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="field">
          <label>Ward *</label>
          <select name="ward_id" required>
            <option value="">Select ward</option>
            <?php $__currentLoopData = $wards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ward): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($ward->id); ?>" <?php echo e(old('ward_id', $bill->ward_id)==$ward->id ? 'selected':''); ?>>
                <?php echo e($ward->name); ?>

              </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
          <?php $__errorArgs = ['ward_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
      </div>

      <div class="field">
        <label>Service type *</label>
        <select name="service" required>
          <option value="">Select service</option>
          <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($service); ?>" <?php echo e(old('service', $bill->service)===$service ? 'selected':''); ?>>
              <?php echo e($service); ?>

            </option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php $__errorArgs = ['service'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="field-row">
        <div class="field">
          <label>Amount (₱) *</label>
          <input type="number" name="amount" value="<?php echo e(old('amount', $bill->amount)); ?>" min="1" required>
          <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="field">
          <label>Due date</label>
          <input type="date" name="due_date" value="<?php echo e(old('due_date', $bill->due_date?->format('Y-m-d'))); ?>">
        </div>
      </div>

      <div class="field">
        <label>Status *</label>
        <select name="status" required>
          <option value="pending" <?php echo e(old('status', $bill->status)==='pending' ? 'selected':''); ?>>Pending</option>
          <option value="paid"    <?php echo e(old('status', $bill->status)==='paid'    ? 'selected':''); ?>>Paid</option>
          <option value="overdue" <?php echo e(old('status', $bill->status)==='overdue' ? 'selected':''); ?>>Overdue</option>
        </select>
      </div>

      <div style="display:flex;gap:10px;margin-top:6px">
        <a href="<?php echo e(route('bills.index')); ?>" class="btn" style="flex:1;text-align:center">Cancel</a>
        <button type="submit" class="btn btn-primary" style="flex:2">Save changes</button>
      </div>
    </form>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\crest\wellmeadows-billing\resources\views/bills/edit.blade.php ENDPATH**/ ?>