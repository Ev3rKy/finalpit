
<?php $__env->startSection('title', 'New Bill — Wellmeadows'); ?>
<?php $__env->startSection('page_title', 'Generate Bill'); ?>
<?php $__env->startSection('sidebar'); ?><?php echo $__env->make('billing.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('top_actions'); ?>
<a href="<?php echo e(route('billing.bills.index')); ?>" class="btn b-ol">← Back to Bills</a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="card" style="padding:24px;max-width:720px">
    <div class="card-title" style="margin-bottom:16px">New Bill · <?php echo e($nextBillNo); ?></div>
    <?php if($patients->isEmpty()): ?>
    <div class="alert-err" style="margin-bottom:16px">No patients registered yet. <a href="<?php echo e(route('patients.index')); ?>" class="act-link">Register a patient</a> in Patient Management first.</div>
    <?php endif; ?>
    <form method="POST" action="<?php echo e(route('billing.bills.store')); ?>"><?php echo csrf_field(); ?>
        <div class="form-grid">
            <label class="full">Patient<select name="patient_select" id="patient_select" required <?php echo e($patients->isEmpty() ? 'disabled' : ''); ?>>
                <option value="">Select registered patient…</option>
                <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($p->patient_no); ?>" <?php echo e(old('patient_select') === $p->patient_no ? 'selected' : ''); ?>><?php echo e($p->patient_no); ?> — <?php echo e($p->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select></label>
            <label>Ward<select name="billing_ward_id" required>
                <option value="">Select ward…</option>
                <?php $__currentLoopData = $wards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($w->id); ?>" <?php echo e(old('billing_ward_id') == $w->id ? 'selected' : ''); ?>>
                    <?php if($w->ward_number): ?>Ward <?php echo e($w->ward_number); ?> — <?php endif; ?><?php echo e($w->name); ?><?php if($w->ward_type): ?> (<?php echo e($w->ward_type); ?>)<?php endif; ?>
                </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select></label>
            <label>Service<select name="service" required><?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($s); ?>" <?php echo e(old('service') === $s ? 'selected' : ''); ?>><?php echo e($s); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <label>Amount (₱)<input type="number" name="amount" min="1" value="<?php echo e(old('amount')); ?>" required></label>
            <label>Due date<input type="date" name="due_date" value="<?php echo e(old('due_date')); ?>"></label>
            <label>Status<select name="status"><option value="pending" <?php echo e(old('status', 'pending') === 'pending' ? 'selected' : ''); ?>>Pending</option><option value="paid" <?php echo e(old('status') === 'paid' ? 'selected' : ''); ?>>Paid</option><option value="overdue" <?php echo e(old('status') === 'overdue' ? 'selected' : ''); ?>>Overdue</option></select></label>
        </div>
        <button type="submit" class="btn b-teal" style="margin-top:16px" <?php echo e($patients->isEmpty() ? 'disabled' : ''); ?>>Generate Bill</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.module', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\pausa\Downloads\V.2\finalpit\finalpit\finalpit\resources\views/billing/bills/create.blade.php ENDPATH**/ ?>