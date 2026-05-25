<?php $__env->startSection('page-title', 'Wards'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
  <div class="card-top">
    <div class="card-title">Ward management</div>
    <a href="<?php echo e(route('wards.create')); ?>" class="btn btn-primary">+ Add ward</a>
  </div>

  <table>
    <thead>
      <tr>
        <th style="width:20%">Ward name</th>
        <th style="width:15%">Total beds</th>
        <th style="width:15%">Occupied</th>
        <th style="width:15%">Available</th>
        <th style="width:15%">Occupancy</th>
        <th style="width:10%">Bills</th>
        <th style="width:10%">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php $__empty_1 = true; $__currentLoopData = $wards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ward): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <?php
        $pct   = $ward->total_beds > 0 ? round(($ward->occupied_beds / $ward->total_beds) * 100) : 0;
        $color = $pct >= 95 ? '#E24B4A' : ($pct >= 80 ? '#185FA5' : '#1D9E75');
      ?>
      <tr>
        <td style="font-weight:600"><?php echo e($ward->name); ?></td>
        <td class="muted"><?php echo e($ward->total_beds); ?></td>
        <td style="font-weight:600;color:<?php echo e($color); ?>"><?php echo e($ward->occupied_beds); ?></td>
        <td class="muted"><?php echo e($ward->total_beds - $ward->occupied_beds); ?></td>
        <td>
          <div style="display:flex;align-items:center;gap:6px">
            <div class="bar-track" style="flex:1;height:6px">
              <div style="width:<?php echo e($pct); ?>%;height:100%;background:<?php echo e($color); ?>;border-radius:4px"></div>
            </div>
            <span style="font-size:11px;color:<?php echo e($color); ?>;font-weight:600;min-width:30px"><?php echo e($pct); ?>%</span>
          </div>
        </td>
        <td class="muted"><?php echo e($ward->bills_count); ?></td>
        <td>
          <div style="display:flex;gap:4px">
            <a href="<?php echo e(route('wards.edit', $ward)); ?>" class="action-btn btn-edit">Edit</a>
            <form method="POST" action="<?php echo e(route('wards.destroy', $ward)); ?>" style="margin:0"
                  onsubmit="return confirm('Delete <?php echo e($ward->name); ?>? This cannot be undone.')">
              <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
              <button type="submit" class="action-btn btn-delete">Delete</button>
            </form>
          </div>
        </td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <tr>
        <td colspan="7" style="padding:30px 0;text-align:center;color:#94A3B8">
          No wards yet. <a href="<?php echo e(route('wards.create')); ?>" style="color:#185FA5">Add the first ward →</a>
        </td>
      </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\crest\wellmeadows-billing\resources\views/wards/index.blade.php ENDPATH**/ ?>