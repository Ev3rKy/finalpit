
<?php $__env->startSection('title', 'New Bill — Wellmeadows'); ?>
<?php $__env->startSection('page_title', 'Generate Bill'); ?>
<?php $__env->startSection('sidebar'); ?><?php echo $__env->make('billing.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('top_actions'); ?>
<a href="<?php echo e(route('billing.bills.index')); ?>" class="btn b-ol">← Back to Bills</a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="card" style="padding:24px;max-width:720px">
    <div class="card-title" style="margin-bottom:16px">New Bill · <?php echo e($nextBillNo); ?></div>
    <form method="POST" action="<?php echo e(route('billing.bills.store')); ?>"><?php echo csrf_field(); ?>
        <div class="form-grid">
            <label>Patient name<input name="patient_name" value="<?php echo e(old('patient_name')); ?>" required></label>
            <label>Patient ID<input name="patient_id" value="<?php echo e(old('patient_id')); ?>" placeholder="P00001" required></label>
            <label>Ward<select name="billing_ward_id" required><?php $__currentLoopData = $wards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($w->id); ?>" <?php echo e(old('billing_ward_id')==$w->id?'selected':''); ?>><?php echo e($w->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <label>Service<select name="service" required><?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($s); ?>" <?php echo e(old('service')===$s?'selected':''); ?>><?php echo e($s); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <label>Amount (₱)<input type="number" name="amount" min="1" value="<?php echo e(old('amount')); ?>" required></label>
            <label>Due date<input type="date" name="due_date" value="<?php echo e(old('due_date')); ?>"></label>
            <label>Status<select name="status"><option value="pending" <?php echo e(old('status','pending')==='pending'?'selected':''); ?>>Pending</option><option value="paid" <?php echo e(old('status')==='paid'?'selected':''); ?>>Paid</option><option value="overdue" <?php echo e(old('status')==='overdue'?'selected':''); ?>>Overdue</option></select></label>
        </div>
        <button type="submit" class="btn b-teal" style="margin-top:16px">Generate Bill</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.module', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\crest\OneDrive\Desktop\finalpit\finalpit\finalpit\resources\views/billing/bills/create.blade.php ENDPATH**/ ?>