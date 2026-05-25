<?php $__env->startSection('page-title', 'Export Report'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
  <div class="card-top">
    <div class="card-title">Export report</div>
    <span class="badge b-blue">Choose format</span>
  </div>
  <div class="muted" style="margin-bottom:4px">Select a format to export the billing report</div>

  <div class="export-grid">
    <a href="<?php echo e(route('reports.download', ['type' => 'pdf'])); ?>" class="export-opt" style="text-decoration:none">
      <div class="opt-icon">📄</div>
      <div class="opt-label">PDF report</div>
      <div class="opt-sub">Formatted document</div>
    </a>
    <a href="<?php echo e(route('reports.download', ['type' => 'csv'])); ?>" class="export-opt" style="text-decoration:none">
      <div class="opt-icon">📊</div>
      <div class="opt-label">CSV spreadsheet</div>
      <div class="opt-sub">Raw data export</div>
    </a>
    <a href="javascript:window.print()" class="export-opt" style="text-decoration:none">
      <div class="opt-icon">🖨️</div>
      <div class="opt-label">Print view</div>
      <div class="opt-sub">Send to printer</div>
    </a>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\crest\wellmeadows-billing\resources\views/reports/export.blade.php ENDPATH**/ ?>