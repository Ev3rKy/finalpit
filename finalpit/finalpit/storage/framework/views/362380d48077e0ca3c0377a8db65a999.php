<?php $fromPatients = request('from') === 'patients' ? ['from' => 'patients'] : []; ?>
<div class="nav-lbl">Ward &amp; Bed Management</div>
<a href="<?php echo e(route('ward-beds.index', $fromPatients)); ?>" class="ni <?php echo e(request()->routeIs('ward-beds.index') && !request('tab') ? 'on' : ''); ?>">Wards</a>
<a href="<?php echo e(route('ward-beds.index', array_merge(['tab' => 'beds'], $fromPatients))); ?>" class="ni <?php echo e(request('tab') === 'beds' ? 'on' : ''); ?>">Bed Matrix</a>
<a href="<?php echo e(route('ward-beds.index', array_merge(['tab' => 'assignments'], $fromPatients))); ?>" class="ni <?php echo e(request('tab') === 'assignments' ? 'on' : ''); ?>">Assignments</a>
<?php if(request('from') === 'patients'): ?>
<a href="<?php echo e(route('admission.index')); ?>" class="ni" style="margin-top:8px">← Back to Patient Management</a>
<?php endif; ?><?php /**PATH C:\Users\pausa\Downloads\V.2\finalpit\finalpit\finalpit\resources\views/ward-beds/partials/sidebar.blade.php ENDPATH**/ ?>