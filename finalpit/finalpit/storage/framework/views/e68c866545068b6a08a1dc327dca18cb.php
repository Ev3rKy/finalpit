<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Wellmeadows Hospital</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; background: #f5f3f0; color: #1a1f5e; min-height: 100vh; }
        .top {
            background: #1a1f5e;
            color: #fff;
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .top h1 { font-size: 1.2rem; }
        .top h1 span { color: #2dd4c0; }
        .badge {
            background: #2dd4c0;
            color: #1a1f5e;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: .7rem;
            font-weight: 700;
            text-transform: uppercase;
        }
        .logout {
            background: rgba(255,255,255,.1);
            color: #fff;
            border: 1px solid rgba(255,255,255,.2);
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: .8rem;
        }
        .wrap { max-width: 1100px; margin: 0 auto; padding: 32px 24px; }
        .welcome { margin-bottom: 28px; }
        .welcome h2 { font-size: 1.5rem; margin-bottom: 6px; }
        .welcome p { color: #666; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px; }
        .card {
            background: #fff;
            border-radius: 14px;
            padding: 20px;
            border: 1px solid #e5e1da;
            text-decoration: none;
            color: inherit;
            transition: box-shadow .15s;
        }
        .card:hover { box-shadow: 0 6px 20px rgba(26,31,94,.1); }
        .card h3 { font-size: 1rem; margin-bottom: 6px; }
        .card p { font-size: .85rem; color: #666; }
        .locked { opacity: .45; pointer-events: none; }
        .flash { background: #d3f9d8; color: #2b8a3e; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; }
    </style>
</head>
<body>
<header class="top">
    <div>
        <h1>Well<span>meadows</span> Hospital</h1>
    </div>
    <div style="display:flex;align-items:center;gap:12px;">
        <span class="badge"><?php echo e($roleLabel); ?></span>
        <span style="font-size:.85rem;"><?php echo e(session('hospital_user_name')); ?></span>
        <form method="POST" action="<?php echo e(route('logout')); ?>" style="margin:0;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="logout" style="cursor:pointer;background:rgba(255,255,255,.1);">Sign out</button>
        </form>
    </div>
</header>

<div class="wrap">
    <?php if(session('success')): ?>
        <div class="flash"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="welcome">
        <h2>Your dashboard</h2>
        <p>Modules available for your role. The system starts empty — add your own data in each module.</p>
    </div>
    <div style="background:#fff;border:1px solid #e5e1da;border-radius:12px;padding:20px;margin-bottom:24px;font-size:.85rem;line-height:1.7;color:#444">
        <strong style="color:#1a2557">Suggested setup order:</strong>
        <ol style="margin:10px 0 0 20px">
            <li><strong>Staff &amp; Departments</strong> — register staff, add wards, assign schedules</li>
            <li><strong>Billing → Wards</strong> — define ward name, type, and bed capacity (for occupancy)</li>
            <li><strong>Patient Management</strong> — register patients, admit/discharge, medications</li>
            <li><strong>Ward &amp; Bed</strong> — add beds and assign patients</li>
            <li><strong>Appointments &amp; Treatment</strong> — schedule visits and record treatments</li>
            <li><strong>Billing</strong> — generate bills and run reports</li>
        </ol>
    </div>

    <?php
        $user = \App\Models\HospitalUser::find(session('hospital_user_id'));
        $can = fn ($m) => $user && $user->canAccessModule($m);
    ?>

    <div class="grid">
        <a href="<?php echo e(route('patients.index')); ?>" class="card <?php echo e($can('patients') ? '' : 'locked'); ?>">
            <h3>Patient Management</h3>
            <p>Register patients, records, admissions.</p>
        </a>
        <a href="<?php echo e(route('staff.index')); ?>" class="card <?php echo e($can('staff') ? '' : 'locked'); ?>">
            <h3>Staff &amp; Departments</h3>
            <p>Staff records, qualifications, ward allocation.</p>
        </a>
        <a href="<?php echo e(route('ward-beds.index')); ?>" class="card <?php echo e($can('ward-beds') ? '' : 'locked'); ?>">
            <h3>Ward &amp; Bed Management</h3>
            <p>Bed matrix, occupancy, assignments.</p>
        </a>
        <a href="<?php echo e(route('appointments.dashboard')); ?>" class="card <?php echo e($can('appointments') ? '' : 'locked'); ?>">
            <h3>Appointments &amp; Treatment</h3>
            <p>Scheduling, treatment history, staff tasks.</p>
        </a>
        <a href="<?php echo e(route('billing.dashboard')); ?>" class="card <?php echo e($can('billing') ? '' : 'locked'); ?>">
            <h3>Billing &amp; Reporting</h3>
            <p>Bills, payments, revenue reports.</p>
        </a>
    </div>
</div>
</body>
</html>
<?php /**PATH C:\Users\crest\OneDrive\Desktop\finalpit\finalpit\finalpit\resources\views/dashboard.blade.php ENDPATH**/ ?>