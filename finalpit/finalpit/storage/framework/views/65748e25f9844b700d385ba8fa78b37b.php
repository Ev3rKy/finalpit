<div class="nav-lbl">Billing &amp; Reporting</div>
<a href="<?php echo e(route('billing.dashboard')); ?>" class="ni <?php echo e(request()->routeIs('billing.dashboard') ? 'on' : ''); ?>">Dashboard</a>
<a href="<?php echo e(route('billing.bills.index')); ?>" class="ni <?php echo e(request()->routeIs('billing.bills.index','billing.bills.show','billing.bills.edit') ? 'on' : ''); ?>">Bills</a>
<a href="<?php echo e(route('billing.bills.create')); ?>" class="ni <?php echo e(request()->routeIs('billing.bills.create') ? 'on' : ''); ?>">New Bill</a>
<a href="<?php echo e(route('billing.bills.outstanding')); ?>" class="ni <?php echo e(request()->routeIs('billing.bills.outstanding') ? 'on' : ''); ?>">Outstanding</a>
<a href="<?php echo e(route('billing.wards.index')); ?>" class="ni <?php echo e(request()->routeIs('billing.wards.*') ? 'on' : ''); ?>">Wards</a>
<a href="<?php echo e(route('billing.reports.revenue')); ?>" class="ni <?php echo e(request()->routeIs('billing.reports.revenue') ? 'on' : ''); ?>">Revenue Report</a>
<a href="<?php echo e(route('billing.reports.occupancy')); ?>" class="ni <?php echo e(request()->routeIs('billing.reports.occupancy') ? 'on' : ''); ?>">Occupancy</a>
<a href="<?php echo e(route('billing.reports.patients')); ?>" class="ni <?php echo e(request()->routeIs('billing.reports.patients') ? 'on' : ''); ?>">Patient Records</a>
<a href="<?php echo e(route('billing.reports.summaries')); ?>" class="ni <?php echo e(request()->routeIs('billing.reports.summaries') ? 'on' : ''); ?>">Summaries</a>
<?php /**PATH C:\Users\crest\OneDrive\Desktop\finalpit\finalpit\finalpit\resources\views/billing/partials/sidebar.blade.php ENDPATH**/ ?>