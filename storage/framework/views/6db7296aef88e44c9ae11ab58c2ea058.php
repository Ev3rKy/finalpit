<?php $__env->startSection('page-title', 'Edit Ward'); ?>

<?php $__env->startSection('content'); ?>
<div class="overlay">
  <div class="modal">
    <div class="modal-title">Edit ward</div>
    <div class="muted" style="font-size:11px;margin-bottom:16px"><?php echo e($ward->name); ?></div>

    <form method="POST" action="<?php echo e(route('wards.update', $ward)); ?>">
      <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

      <div class="field">
        <label>Ward name *</label>
        <input type="text" name="name" value="<?php echo e(old('name', $ward->name)); ?>" required>
        <?php $__errorArgs = ['name'];
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
          <label>Total beds *</label>
          <input type="number" name="total_beds" value="<?php echo e(old('total_beds', $ward->total_beds)); ?>" min="1" required>
          <?php $__errorArgs = ['total_beds'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="field-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="field">
          <label>Occupied beds</label>
          <input type="number" name="occupied_beds" value="<?php echo e(old('occupied_beds', $ward->occupied_beds)); ?>" min="0" disabled
                 style="background:#F1F5F9;color:#94A3B8;cursor:not-allowed">
          <div style="font-size:10px;color:#94A3B8;margin-top:3px">Auto-calculated from active bills</div>
        </div>
      </div>

      <div style="display:flex;gap:10px;margin-top:6px">
        <a href="<?php echo e(route('wards.index')); ?>" class="btn" style="flex:1;text-align:center">Cancel</a>
        <button type="submit" class="btn btn-primary" style="flex:2">Save changes</button>
      </div>
    </form>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\crest\wellmeadows-billing\resources\views/wards/edit.blade.php ENDPATH**/ ?>