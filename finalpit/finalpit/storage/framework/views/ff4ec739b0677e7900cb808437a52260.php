<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Directory — Wellmeadows</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy:#1a2557; --navy2:#232d6b; --teal:#00c9a7; --teal2:#00b096;
            --bg:#f0f2f5; --white:#ffffff; --border:#e2e8f0;
            --text:#1e293b; --muted:#64748b; --err:#e53e3e; --ok:#38a169;
            --card:#ffffff;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',sans-serif; background:var(--bg); color:var(--text); font-size:13px; height:100vh; overflow:hidden; display:flex; }

        /* SIDEBAR */
        .sb { width:220px; background:var(--navy); display:flex; flex-direction:column; flex-shrink:0; height:100vh; }
        .sb-brand { padding:20px 18px 16px; border-bottom:1px solid rgba(255,255,255,.08); }
        .sb-logo { font-size:18px; font-weight:700; color:#fff; }
        .sb-logo span { color:var(--teal); }
        .sb-ver { font-size:10px; color:rgba(255,255,255,.3); margin-top:2px; }
        .sb-nav { padding:16px 0; flex:1; }
        .nav-lbl { padding:8px 18px 4px; font-size:9px; font-weight:600; color:rgba(255,255,255,.3); text-transform:uppercase; letter-spacing:.12em; }
        .ni { display:flex; align-items:center; gap:10px; padding:10px 18px; color:rgba(255,255,255,.6); font-size:12px; text-decoration:none; transition:all .15s; border-left:3px solid transparent; }
        .ni:hover { background:rgba(255,255,255,.07); color:#fff; }
        .ni.on { background:rgba(0,201,167,.1); color:var(--teal); border-left-color:var(--teal); font-weight:500; }
        .sb-footer { padding:14px 18px; border-top:1px solid rgba(255,255,255,.08); font-size:10px; color:rgba(255,255,255,.3); }

        /* MAIN */
        .main { flex:1; display:flex; flex-direction:column; overflow:hidden; }
        .topbar { background:var(--navy); padding:0 28px; display:flex; align-items:center; justify-content:space-between; height:60px; flex-shrink:0; }
        .tb-title { font-size:11px; font-weight:700; color:rgba(255,255,255,.5); text-transform:uppercase; letter-spacing:.1em; }
        .tb-page { font-size:16px; font-weight:700; color:#fff; margin-top:1px; }
        .tb-r { display:flex; align-items:center; gap:12px; }
        .tb-date { font-size:12px; color:rgba(255,255,255,.6); }
        .av { width:36px; height:36px; border-radius:50%; background:var(--teal); color:#fff; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; }
        .content { flex:1; overflow-y:auto; padding:24px 28px; }

        /* STATS */
        .stats { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:22px; }
        .stat { background:var(--card); border-radius:10px; padding:18px 20px; border:1px solid var(--border); }
        .stat.navy { background:var(--navy); }
        .stat.teal { background:var(--teal); }
        .stat-l { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--muted); }
        .stat.navy .stat-l, .stat.teal .stat-l { color:rgba(255,255,255,.7); }
        .stat-n { font-size:28px; font-weight:700; color:var(--text); margin:6px 0 4px; }
        .stat.navy .stat-n, .stat.teal .stat-n { color:#fff; }
        .stat-s { font-size:11px; color:var(--muted); }
        .stat.navy .stat-s, .stat.teal .stat-s { color:rgba(255,255,255,.6); }

        /* CARD */
        .card { background:var(--card); border-radius:10px; border:1px solid var(--border); margin-bottom:16px; overflow:hidden; }
        .card-hd { padding:16px 20px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; }
        .card-title { font-size:14px; font-weight:600; color:var(--text); }
        .card-sub { font-size:11px; color:var(--muted); margin-top:2px; }

        /* SEARCH */
        .sr { display:flex; gap:10px; margin-bottom:16px; }
        .sinp { flex:1; padding:9px 14px; border:1.5px solid var(--border); border-radius:8px; font-size:12px; font-family:'Inter',sans-serif; background:var(--white); color:var(--text); outline:none; }
        .sinp:focus { border-color:var(--teal); }
        .fsel { padding:9px 12px; border:1.5px solid var(--border); border-radius:8px; font-size:12px; font-family:'Inter',sans-serif; background:var(--white); color:var(--text); outline:none; }

        /* TABLE */
        .tbl { width:100%; border-collapse:collapse; }
        .tbl th { text-align:left; padding:10px 20px; font-size:10px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:.07em; border-bottom:1px solid var(--border); background:#f8fafc; }
        .tbl td { padding:13px 20px; border-bottom:1px solid var(--border); font-size:12px; color:var(--text); vertical-align:middle; }
        .tbl tr:last-child td { border-bottom:none; }
        .tbl tr:hover td { background:#f8fafc; }

        /* PATIENT AVATAR STYLE */
        .p-av { width:32px; height:32px; border-radius:50%; background:var(--navy); color:#fff; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; flex-shrink:0; }
        .p-info { display:flex; align-items:center; gap:10px; }

        /* BADGES */
        .bdg { display:inline-block; padding:3px 10px; border-radius:20px; font-size:10px; font-weight:600; }
        .bp { background:#c6f6d5; color:#276749; }
        .bt { background:#fed7d7; color:#9b2c2c; }
        .be { background:#bee3f8; color:#2a69ac; }
        .bl { background:#fefcbf; color:#7b6008; }
        .bn { background:#e9d8fd; color:#553c9a; }
        .br { background:#e2e8f0; color:var(--navy); }

        /* BUTTONS */
        .btn { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:8px; font-size:12px; font-weight:600; cursor:pointer; border:none; font-family:'Inter',sans-serif; text-decoration:none; transition:all .15s; }
        .b-teal { background:var(--teal); color:#fff; }
        .b-teal:hover { background:var(--teal2); }
        .b-nv { background:var(--navy); color:#fff; }
        .b-ol { background:transparent; color:var(--navy); border:1.5px solid var(--border); }
        .b-ol:hover { background:#f8fafc; }
        .b-dn { background:#fff5f5; color:var(--err); border:1px solid #fed7d7; }
        .b-sm { padding:5px 12px; font-size:11px; border-radius:6px; }
        .td-act { display:flex; gap:5px; align-items:center; }

        /* ALERT */
        .alert-ok { background:#f0fff4; color:#276749; padding:12px 16px; border-radius:8px; margin-bottom:16px; font-size:12px; border:1px solid #c6f6d5; font-weight:500; }
        .mono { font-family:'DM Mono',monospace; font-size:11px; color:var(--teal2); }

        /* PAGE HDR */
        .ph { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; }
        .ph-title { font-size:18px; font-weight:700; color:var(--text); }
        .ph-sub { font-size:11px; color:var(--muted); margin-top:2px; }
    </style>
</head>
<body>

<div class="sb">
    <div class="sb-brand">
        <div class="sb-logo">Well<span>meadows</span></div>
        <div class="sb-ver">Hospital Management System</div>
    </div>
    <div class="sb-nav">
        <div class="nav-lbl">Staff Module</div>
        <a href="<?php echo e(route('staff.index')); ?>" class="ni on">👥 Staff Directory</a>
        <a href="<?php echo e(route('staff.create')); ?>" class="ni">＋ Add Staff</a>
        <a href="<?php echo e(route('ward-allocation.index')); ?>" class="ni">📅 Ward Allocation</a>
        <div class="nav-lbl" style="margin-top:8px">System</div>
        <a href="/" class="ni">🏠 Home</a>
    </div>
    <div class="sb-footer">Wellmeadows v1.0</div>
</div>

<div class="main">
    <div class="topbar">
        <div>
            <div class="tb-title">Staff Module</div>
            <div class="tb-page">Staff Directory</div>
        </div>
        <div class="tb-r">
            <div class="tb-date"><?php echo e(date('d M Y')); ?></div>
            <div class="av">PO</div>
        </div>
    </div>

    <div class="content">

        <?php if(session('success')): ?>
            <div class="alert-ok">✓ <?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <div class="stats">
            <div class="stat navy">
                <div class="stat-l">Total Staff</div>
                <div class="stat-n"><?php echo e(count($staff)); ?></div>
                <div class="stat-s">All hospital staff</div>
            </div>
            <div class="stat teal">
                <div class="stat-l">Permanent</div>
                <div class="stat-n"><?php echo e($staff->where('contract_type','Permanent')->count()); ?></div>
                <div class="stat-s">Permanent contracts</div>
            </div>
            <div class="stat">
                <div class="stat-l">Temporary</div>
                <div class="stat-n"><?php echo e($staff->where('contract_type','Temporary')->count()); ?></div>
                <div class="stat-s">Temporary contracts</div>
            </div>
            <div class="stat">
                <div class="stat-l">Positions</div>
                <div class="stat-n"><?php echo e($staff->pluck('position')->unique()->count()); ?></div>
                <div class="stat-s">Unique roles</div>
            </div>
        </div>

        <div class="ph">
            <div>
                <div class="ph-title">Staff Directory</div>
                <div class="ph-sub">All hospital staff members</div>
            </div>
            <a href="<?php echo e(route('staff.create')); ?>" class="btn b-teal">+ New Staff</a>
        </div>

        <div class="sr">
            <input class="sinp" type="text" placeholder="🔍  Search by name, staff number, or position...">
            <select class="fsel">
                <option>All Positions</option>
                <option>Charge Nurse</option>
                <option>Staff Nurse</option>
                <option>Nurse</option>
                <option>Consultant</option>
                <option>Doctor</option>
                <option>Auxiliary</option>
            </select>
            <select class="fsel">
                <option>All Contracts</option>
                <option>Permanent</option>
                <option>Temporary</option>
            </select>
        </div>

        <div class="card">
            <div class="card-hd">
                <div>
                    <div class="card-title">Staff Register</div>
                    <div class="card-sub">Showing <?php echo e(count($staff)); ?> staff members</div>
                </div>
            </div>
            <table class="tbl">
                <thead>
                    <tr>
                        <th>Staff</th>
                        <th>Staff No.</th>
                        <th>Position</th>
                        <th>NIN</th>
                        <th>Salary</th>
                        <th>Contract</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div class="p-info">
                                <div class="p-av"><?php echo e(strtoupper(substr($s->first_name,0,1).substr($s->last_name,0,1))); ?></div>
                                <strong><?php echo e($s->first_name); ?> <?php echo e($s->last_name); ?></strong>
                            </div>
                        </td>
                        <td class="mono"><?php echo e($s->staff_number); ?></td>
                        <td><span class="bdg br"><?php echo e($s->position); ?></span></td>
                        <td class="mono"><?php echo e($s->nin); ?></td>
                        <td>£<?php echo e(number_format($s->current_salary, 2)); ?></td>
                        <td>
                            <span class="bdg <?php echo e($s->contract_type == 'Permanent' ? 'bp' : 'bt'); ?>">
                                <?php echo e($s->contract_type); ?>

                            </span>
                        </td>
                        <td>
                            <div class="td-act">
                                <a href="<?php echo e(route('staff.show', $s->staff_number)); ?>" class="btn b-ol b-sm">View →</a>
                                <a href="<?php echo e(route('staff.edit', $s->staff_number)); ?>" class="btn b-ol b-sm">Edit →</a>
                                <form action="<?php echo e(route('staff.destroy', $s->staff_number)); ?>" method="POST" style="display:inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn b-dn b-sm" onclick="return confirm('Delete this staff member?')">Del</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" style="text-align:center;padding:40px;color:var(--muted)">
                            No staff members found. <a href="<?php echo e(route('staff.create')); ?>" style="color:var(--teal)">Add one now →</a>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

</body>
</html><?php /**PATH C:\Users\crest\OneDrive\Desktop\finalpit\finalpit\finalpit\resources\views/staff/index.blade.php ENDPATH**/ ?>