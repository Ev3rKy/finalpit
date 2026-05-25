

<?php $__env->startSection('title', 'Ward Allocation — Wellmeadows'); ?>
<?php $__env->startSection('top_title', 'Ward Allocation'); ?>
<?php $__env->startSection('top_sub', 'WEEKLY SHIFT SCHEDULE'); ?>

<?php $__env->startSection('content'); ?>
<div class="sh">
    <div>
        <div class="sh-title">Ward Allocation</div>
        <div class="sh-sub">Weekly shift schedule by ward</div>
    </div>
    <div style="display:flex;gap:8px">
        <button class="btn b-ol" type="button" onclick="toggleForm('addWardForm')">+ Add Ward</button>
        <button class="btn b-nv" type="button" onclick="toggleForm('addForm')">+ Assign Staff</button>
    </div>
</div>

<?php if($wards->isEmpty()): ?>
<div class="alert-err" style="background:#fffbeb;color:#92400e;border-color:#fde68a;margin-bottom:16px">
    Add at least one ward (name, type, capacity) before assigning staff to shifts.
</div>
<?php endif; ?>

<div class="card" style="margin-bottom:16px">
    <div class="card-hd"><div class="card-title">Hospital Wards</div></div>
    <table class="tbl">
        <thead><tr><th>No.</th><th>Name</th><th>Type</th><th>Location</th><th>Capacity</th><th>Actions</th></tr></thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $wards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><?php echo e($w->ward_number); ?></td>
            <td><strong><?php echo e($w->ward_name); ?></strong></td>
            <td><?php echo e($w->ward_type ?? '—'); ?></td>
            <td><?php echo e($w->location ?? '—'); ?></td>
            <td><?php echo e($w->total_beds); ?></td>
            <td>
                <form method="POST" action="<?php echo e(route('ward-allocation.wards.destroy', $w->ward_number)); ?>" onsubmit="return confirm('Delete this ward?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn b-dn b-sm">Delete</button></form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="6" style="text-align:center;padding:24px;color:var(--muted)">No wards defined. Click <strong>+ Add Ward</strong> above.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
    <div class="add-form" id="addWardForm">
        <form action="<?php echo e(route('ward-allocation.wards.store')); ?>" method="POST" style="padding:16px 20px">
            <?php echo csrf_field(); ?>
            <div class="fg-inline" style="grid-template-columns:repeat(5,1fr) auto">
                <div class="fgp"><label>Ward No. *</label><input type="number" name="ward_number" min="1" required></div>
                <div class="fgp"><label>Name *</label><input name="ward_name" required></div>
                <div class="fgp"><label>Type</label><select name="ward_type"><option value="">—</option><?php $__currentLoopData = ['General','ICU','Pediatric','Maternity','Surgical']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option><?php echo e($t); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
                <div class="fgp"><label>Location</label><input name="location" placeholder="Block A"></div>
                <div class="fgp"><label>Capacity *</label><input type="number" name="total_beds" min="1" value="20" required></div>
                <div style="display:flex;gap:6px;align-items:flex-end"><button type="submit" class="btn b-nv b-sm">Save Ward</button></div>
            </div>
        </form>
    </div>
</div>

<div class="filters">
    <select class="fsel" id="wardFilter">
        <option value="">All Wards</option>
        <?php $__currentLoopData = $wards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ward): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($ward->ward_number); ?>">Ward <?php echo e($ward->ward_number); ?> – <?php echo e($ward->ward_name); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <select class="fsel" id="weekFilter">
        <option value="">All Weeks</option>
        <?php $__currentLoopData = $weeks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $week): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($week); ?>">Week: <?php echo e(\Carbon\Carbon::parse($week)->format('d M Y')); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <select class="fsel" id="shiftFilter">
        <option value="">All Shifts</option>
        <option value="Early">Early</option>
        <option value="Late">Late</option>
        <option value="Night">Night</option>
    </select>
</div>

<?php if($selectedWard): ?>
<div class="ward-info" id="wardInfoBanner">
    <div>
        <div class="wi-title">Ward <?php echo e($selectedWard->ward_number); ?> — <?php echo e($selectedWard->ward_name); ?></div>
        <div class="wi-sub">
            <?php echo e($selectedWard->location ?? 'Hospital'); ?>

            <?php if($selectedWard->tel_extn): ?> · Tel Ext: <?php echo e($selectedWard->tel_extn); ?> <?php endif; ?>
        </div>
    </div>
    <div class="wi-stats">
        <div class="wi-stat">
            <div class="wi-stat-n" id="statEarly"><?php echo e($allocations->where('shift','Early')->count()); ?></div>
            <div class="wi-stat-l">Early</div>
        </div>
        <div class="wi-stat">
            <div class="wi-stat-n" id="statLate"><?php echo e($allocations->where('shift','Late')->count()); ?></div>
            <div class="wi-stat-l">Late</div>
        </div>
        <div class="wi-stat">
            <div class="wi-stat-n" id="statNight"><?php echo e($allocations->where('shift','Night')->count()); ?></div>
            <div class="wi-stat-l">Night</div>
        </div>
        <div class="wi-stat">
            <div class="wi-stat-n" id="statTotal"><?php echo e($allocations->count()); ?></div>
            <div class="wi-stat-l">Total</div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="shift-grid">
    <?php $__currentLoopData = ['Early' => 'ea', 'Late' => 'lt', 'Night' => 'nt']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shiftName => $shiftClass): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="scard shift-card" data-shift="<?php echo e($shiftName); ?>">
        <div class="shd <?php echo e($shiftClass); ?>">
            <div class="sl">
                <?php if($shiftName === 'Early'): ?> 🌅 Early Shift
                <?php elseif($shiftName === 'Late'): ?> 🌤 Late Shift
                <?php else: ?> 🌙 Night Shift
                <?php endif; ?>
            </div>
            <div class="st">
                <?php if($shiftName === 'Early'): ?> 06:00 – 14:00
                <?php elseif($shiftName === 'Late'): ?> 14:00 – 22:00
                <?php else: ?> 22:00 – 06:00
                <?php endif; ?>
            </div>
        </div>
        <div class="sbody" id="shiftBody<?php echo e($shiftName); ?>">
            <?php $shiftItems = $allocations->where('shift', $shiftName); ?>
            <?php $__empty_1 = true; $__currentLoopData = $shiftItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="sp alloc-item"
                 data-ward="<?php echo e($a->ward_number); ?>"
                 data-week="<?php echo e($a->week_start_date); ?>"
                 data-shift="<?php echo e($a->shift); ?>">
                <div class="spav"><?php echo e(strtoupper(substr($a->staff->first_name,0,1).substr($a->staff->last_name,0,1))); ?></div>
                <div>
                    <div class="spn"><?php echo e($a->staff->first_name); ?> <?php echo e($a->staff->last_name); ?></div>
                    <div class="spp"><?php echo e($a->staff->position); ?></div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="sempty alloc-empty">No staff assigned</div>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="card">
    <div class="card-hd">
        <div>
            <div class="card-title">Full Allocation Table</div>
            <div class="card-sub">All staff assignments for this period</div>
        </div>
    </div>

    <div class="add-form" id="addForm">
        <form action="<?php echo e(route('ward-allocation.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="fg-inline">
                <div class="fgp">
                    <label>Staff Member *</label>
                    <select name="staff_number" required>
                        <option value="">-- Select Staff --</option>
                        <?php $__currentLoopData = $staffList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($s->staff_number); ?>"><?php echo e($s->first_name); ?> <?php echo e($s->last_name); ?> (<?php echo e($s->position); ?>)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="fgp">
                    <label>Ward *</label>
                    <select name="ward_number" required>
                        <option value="">-- Select Ward --</option>
                        <?php $__currentLoopData = $wards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($w->ward_number); ?>">Ward <?php echo e($w->ward_number); ?> – <?php echo e($w->ward_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="fgp">
                    <label>Week Start Date *</label>
                    <input type="date" name="week_start_date" required>
                </div>
                <div class="fgp">
                    <label>Shift *</label>
                    <select name="shift" required>
                        <option value="">-- Select --</option>
                        <option value="Early">Early (06:00-14:00)</option>
                        <option value="Late">Late (14:00-22:00)</option>
                        <option value="Night">Night (22:00-06:00)</option>
                    </select>
                </div>
                <div style="display:flex;gap:6px;align-items:flex-end;padding-bottom:1px">
                    <button type="submit" class="btn b-nv b-sm">Assign</button>
                    <button type="button" class="btn b-ol b-sm" onclick="toggleForm('addForm')">Cancel</button>
                </div>
            </div>
        </form>
    </div>

    <table class="tbl" id="allocationTable">
        <thead>
            <tr>
                <th>Staff</th>
                <th>Staff No.</th>
                <th>Position</th>
                <th>Ward</th>
                <th>Week Start</th>
                <th>Shift</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $allocations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="alloc-row"
                data-ward="<?php echo e($a->ward_number); ?>"
                data-week="<?php echo e($a->week_start_date); ?>"
                data-shift="<?php echo e($a->shift); ?>">
                <td>
                    <div class="p-info">
                        <div class="p-av"><?php echo e(strtoupper(substr($a->staff->first_name,0,1).substr($a->staff->last_name,0,1))); ?></div>
                        <strong><?php echo e($a->staff->first_name); ?> <?php echo e($a->staff->last_name); ?></strong>
                    </div>
                </td>
                <td class="mono"><?php echo e($a->staff_number); ?></td>
                <td><span class="bdg br"><?php echo e($a->staff->position); ?></span></td>
                <td>Ward <?php echo e($a->ward_number); ?></td>
                <td><?php echo e(\Carbon\Carbon::parse($a->week_start_date)->format('d M Y')); ?></td>
                <td>
                    <span class="bdg <?php echo e($a->shift=='Early'?'be':($a->shift=='Late'?'bl':'bn')); ?>">
                        <?php echo e($a->shift); ?>

                    </span>
                </td>
                <td>
                    <form action="<?php echo e(route('ward-allocation.destroy', $a->allocation_id)); ?>" method="POST" style="display:inline">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn b-dn b-sm" onclick="return confirm('Remove this assignment?')">Remove</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr id="noAllocRow">
                <td colspan="7" style="text-align:center;padding:40px;color:var(--muted)">
                    No staff assigned yet.
                    <button type="button" class="btn b-nv b-sm" onclick="toggleForm('addForm')" style="margin-left:8px">+ Assign Staff</button>
                </td>
            </tr>
            <?php endif; ?>
            <tr id="noAllocFilterRow" style="display:none">
                <td colspan="7" style="text-align:center;padding:40px;color:var(--muted)">
                    No assignments match the selected filters.
                </td>
            </tr>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function toggleForm(id) {
    document.getElementById(id).classList.toggle('show');
}

(function () {
    const wardFilter = document.getElementById('wardFilter');
    const weekFilter = document.getElementById('weekFilter');
    const shiftFilter = document.getElementById('shiftFilter');
    const rows = Array.from(document.querySelectorAll('.alloc-row'));
    const items = Array.from(document.querySelectorAll('.alloc-item'));
    const noFilterRow = document.getElementById('noAllocFilterRow');

    function updateStats() {
        const visible = rows.filter(r => r.style.display !== 'none');
        const count = (shift) => visible.filter(r => r.dataset.shift === shift).length;
        const stat = (id, n) => { const el = document.getElementById(id); if (el) el.textContent = n; };
        stat('statEarly', count('Early'));
        stat('statLate', count('Late'));
        stat('statNight', count('Night'));
        stat('statTotal', visible.length);
    }

    function filterAllocations() {
        const ward = wardFilter?.value || '';
        const week = weekFilter?.value || '';
        const shift = shiftFilter?.value || '';
        let visibleRows = 0;

        rows.forEach(row => {
            const show = (!ward || row.dataset.ward === ward)
                && (!week || row.dataset.week === week)
                && (!shift || row.dataset.shift === shift);
            row.style.display = show ? '' : 'none';
            if (show) visibleRows++;
        });

        items.forEach(item => {
            const show = (!ward || item.dataset.ward === ward)
                && (!week || item.dataset.week === week)
                && (!shift || item.dataset.shift === shift);
            item.style.display = show ? '' : 'none';
        });

        document.querySelectorAll('.shift-card').forEach(card => {
            const shiftName = card.dataset.shift;
            const body = card.querySelector('.sbody');
            const visibleInShift = items.filter(i =>
                i.dataset.shift === shiftName && i.style.display !== 'none'
            );
            const empty = body?.querySelector('.alloc-empty');
            if (empty) empty.style.display = visibleInShift.length ? 'none' : '';
        });

        if (noFilterRow) {
            noFilterRow.style.display = rows.length && visibleRows === 0 ? '' : 'none';
        }
        updateStats();
    }

    wardFilter?.addEventListener('change', filterAllocations);
    weekFilter?.addEventListener('change', filterAllocations);
    shiftFilter?.addEventListener('change', filterAllocations);
})();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.staff', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\crest\OneDrive\Desktop\finalpit\finalpit\finalpit\resources\views/ward-allocation/index.blade.php ENDPATH**/ ?>