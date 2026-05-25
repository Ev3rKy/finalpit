
<?php $__env->startSection('title', 'Edit Ward — Wellmeadows'); ?>
<?php $__env->startSection('page_title', 'Edit Billing Ward'); ?>
<?php $__env->startSection('sidebar'); ?><?php echo $__env->make('billing.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('top_actions'); ?><a href="<?php echo e(route('billing.wards.index')); ?>" class="btn b-ol">← Back</a><?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="card" style="padding:24px;max-width:480px">
    <form method="POST" action="<?php echo e(route('billing.wards.update', $ward)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <div class="form-grid">
            <label class="full">Ward name<input name="name" value="<?php echo e(old('name', $ward->name)); ?>" required></label>
            <label>Total beds<input type="number" name="total_beds" min="1" value="<?php echo e(old('total_beds', $ward->total_beds)); ?>" required></label>
            <label>Occupied beds<input type="number" name="occupied_beds" min="0" value="<?php echo e(old('occupied_beds', $ward->occupied_beds)); ?>" readonly style="opacity:.6"></label>
        </div>
        <button type="submit" class="btn b-teal" style="margin-top:16px">Update Ward</button>
    </form>
    <form method="POST" action="<?php echo e(route('billing.wards.destroy', $ward)); ?>" style="margin-top:12px" onsubmit="return confirm('Delete ward?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button type="submit" class="btn b-dn">Delete Ward</button></form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.module', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\crest\OneDrive\Desktop\finalpit\finalpit\finalpit\resources\views/billing/wards/edit.blade.php ENDPATH**/ ?>