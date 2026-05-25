
<?php $__env->startSection('title', 'Medical Records — Wellmeadows'); ?>
<?php $__env->startSection('page_title', 'Medical Records'); ?>
<?php $__env->startSection('content'); ?>
<h2 style="font-size:20px;font-weight:700;color:var(--navy);margin-bottom:6px">Select a Patient</h2>
<p style="color:var(--muted);margin-bottom:20px;font-size:13px">Choose a patient below to view or manage their medical records.</p>
<div class="card">
    <div class="card-hd">
        <div class="card-title">All Patients</div>
        <input type="text" class="sinp" placeholder="Search patient…" onkeyup="filterMed(this.value)">
    </div>
    <table class="tbl" id="medTable">
        <thead><tr><th>Patient</th><th>Patient No.</th><th>Date of Birth</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
        <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr data-search="<?php echo e(strtolower($p->name.' '.$p->patient_no)); ?>">
            <td><div class="p-info"><div class="p-av"><?php echo e($p->initials); ?></div><div><strong><?php echo e($p->name); ?></strong><div style="font-size:11px;color:var(--muted)">Registered <?php echo e($p->date_registered?->format('d M Y')); ?></div></div></div></td>
            <td class="mono"><?php echo e($p->patient_no); ?></td>
            <td><?php echo e($p->date_of_birth?->format('d M Y') ?? '—'); ?></td>
            <td><span class="bdg <?php echo e($p->status === 'IN-PATIENT' ? 'bp' : 'bo'); ?>"><?php echo e($p->status); ?></span></td>
            <td><a href="<?php echo e(route('patients.medical', $p->id)); ?>" class="btn b-nv b-sm">View Records →</a></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>function filterMed(q){q=q.toLowerCase();document.querySelectorAll('#medTable tbody tr[data-search]').forEach(tr=>tr.style.display=tr.dataset.search.includes(q)?'':'none');}</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.hospital', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\pausa\Downloads\V.2\finalpit\finalpit\finalpit\resources\views/patients/medical_index.blade.php ENDPATH**/ ?>