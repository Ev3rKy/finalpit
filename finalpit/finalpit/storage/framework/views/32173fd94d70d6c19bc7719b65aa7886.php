
<?php $__env->startSection('title', 'Bill <?php echo e($bill->bill_no); ?> — Wellmeadows'); ?>
<?php $__env->startSection('page_title', 'Bill Details'); ?>
<?php $__env->startSection('sidebar'); ?><?php echo $__env->make('billing.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('top_actions'); ?>
<a href="<?php echo e(route('billing.bills.edit', $bill)); ?>" class="btn b-teal">Edit Bill</a>
<a href="<?php echo e(route('billing.bills.index')); ?>" class="btn b-ol">← Back</a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="pb">
    <div class="pav"><?php echo e($bill->initials); ?></div>
    <div>
        <div class="pn"><?php echo e($bill->patient_name); ?></div>
        <div class="pr"><?php echo e($bill->bill_no); ?> · <?php echo e($bill->patient_id); ?></div>
        <div class="pm">
            <div class="pmi"><strong>Amount</strong><?php echo e($bill->formatted_amount); ?></div>
            <div class="pmi"><strong>Status</strong><?php echo $bill->status_badge; ?></div>
            <div class="pmi"><strong>Ward</strong><?php echo e($bill->ward?->name ?? '—'); ?></div>
            <div class="pmi"><strong>Service</strong><?php echo e($bill->service); ?></div>
            <div class="pmi"><strong>Due</strong><?php echo e($bill->due_date?->format('d M Y') ?? '—'); ?></div>
        </div>
    </div>
    <?php if($bill->status !== 'paid'): ?>
    <form method="POST" action="<?php echo e(route('billing.bills.pay', $bill)); ?>" style="margin-left:auto"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
    <button type="submit" class="btn b-teal">Mark as Paid</button></form>
    <?php endif; ?>
</div>
<div class="card" style="padding:24px">
    <p><strong>Paid at:</strong> <?php echo e($bill->paid_at?->format('d M Y g:i A') ?? 'Not yet paid'); ?></p>
    <p style="margin-top:12px"><strong>Created:</strong> <?php echo e($bill->created_at?->format('d M Y')); ?></p>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.module', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\crest\OneDrive\Desktop\finalpit\finalpit\finalpit\resources\views/billing/bills/show.blade.php ENDPATH**/ ?>