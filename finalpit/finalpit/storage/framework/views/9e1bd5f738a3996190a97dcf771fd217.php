
<?php $__env->startSection('title', 'Add Ward — Wellmeadows'); ?>
<?php $__env->startSection('page_title', 'Add Billing Ward'); ?>
<?php $__env->startSection('sidebar'); ?><?php echo $__env->make('billing.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('top_actions'); ?><a href="<?php echo e(route('billing.wards.index')); ?>" class="btn b-ol">← Back</a><?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="card" style="padding:24px;max-width:480px">
    <form method="POST" action="<?php echo e(route('billing.wards.store')); ?>"><?php echo csrf_field(); ?>
        <div class="form-grid">
            <label class="full">Ward name<input name="name" value="<?php echo e(old('name')); ?>" required></label>
            <label>Ward type<select name="ward_type">
                <option value="">Select type…</option>
                <?php $__currentLoopData = ['General','ICU','Pediatric','Maternity','Surgical','Isolation']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($t); ?>" <?php echo e(old('ward_type')===$t?'selected':''); ?>><?php echo e($t); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select></label>
            <label>Capacity (beds)<input type="number" name="total_beds" min="1" value="<?php echo e(old('total_beds', 10)); ?>" required></label>
        </div>
        <button type="submit" class="btn b-teal" style="margin-top:16px">Add Ward</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.module', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\crest\OneDrive\Desktop\finalpit\finalpit\finalpit\resources\views/billing/wards/create.blade.php ENDPATH**/ ?>