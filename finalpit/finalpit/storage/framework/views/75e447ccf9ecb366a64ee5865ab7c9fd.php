<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Wellmeadows'); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy:#1a2557;
            --navy2:#232d6b;
            --bg:#f0f2f5;
            --surface:#f8fafc;
            --white:#ffffff;
            --teal:#00c9a7;
            --teal2:#00b096;
            --border:#e2e8f0;
            --text:#1e293b;
            --muted:#64748b;
            --err:#e53e3e;
            --ok:#2d7a5a;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',sans-serif; background:var(--bg); color:var(--text); font-size:13px; height:100vh; overflow:hidden; display:flex; }

        .sb { width:220px; background:var(--navy); display:flex; flex-direction:column; flex-shrink:0; height:100vh; }
        .sb-brand { padding:20px 18px 16px; border-bottom:1px solid rgba(255,255,255,.08); }
        .sb-logo { font-size:18px; font-weight:700; color:#fff; }
        .sb-logo span { color:var(--teal); }
        .sb-ver { font-size:10px; color:rgba(255,255,255,.35); margin-top:4px; }
        .sb-nav { padding:16px 0; flex:1; }
        .nav-lbl { padding:8px 18px 4px; font-size:9px; font-weight:600; color:rgba(255,255,255,.3); text-transform:uppercase; letter-spacing:.12em; }
        .ni { display:flex; align-items:center; gap:10px; padding:10px 18px; color:rgba(255,255,255,.6); font-size:12px; text-decoration:none; transition:all .15s; border-left:3px solid transparent; }
        .ni:hover { background:rgba(255,255,255,.07); color:#fff; }
        .ni.on { background:rgba(0,201,167,.1); color:var(--teal); border-left-color:var(--teal); font-weight:500; }
        .sb-footer { padding:14px 18px; border-top:1px solid rgba(255,255,255,.08); font-size:10px; color:rgba(255,255,255,.3); }

        .main { flex:1; display:flex; flex-direction:column; overflow:hidden; }
        .topbar { background:var(--navy); padding:0 28px; display:flex; align-items:center; justify-content:space-between; height:60px; flex-shrink:0; }
        .tb-ward { font-size:16px; font-weight:700; color:#fff; }
        .tb-sub { font-size:11px; font-weight:600; color:rgba(255,255,255,.5); text-transform:uppercase; letter-spacing:.1em; margin-top:2px; }
        .tb-r { display:flex; align-items:center; gap:12px; font-size:12px; color:rgba(255,255,255,.6); }
        .av { width:36px; height:36px; border-radius:50%; background:var(--teal); color:#fff; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; }
        .content { flex:1; overflow-y:auto; padding:24px 28px; background:var(--bg); }

        .sh { display:flex; align-items:flex-end; justify-content:space-between; margin-bottom:18px; }
        .sh-title { font-size:18px; font-weight:700; color:var(--text); }
        .sh-sub { font-size:11px; color:var(--muted); margin-top:2px; }
        .bc { display:flex; align-items:center; gap:6px; font-size:11px; color:var(--muted); margin-bottom:16px; }
        .bc a { color:var(--teal2); text-decoration:none; font-weight:500; }

        .sr { display:flex; gap:10px; margin-bottom:16px; align-items:center; }
        .sw { flex:1; position:relative; }
        .sinp { width:100%; padding:9px 12px; border:1.5px solid var(--border); border-radius:8px; font-size:12px; font-family:'Inter',sans-serif; background:var(--white); color:var(--text); outline:none; }
        .sinp:focus { border-color:var(--teal); box-shadow:0 0 0 3px rgba(0,201,167,.12); }
        .fsel { padding:9px 12px; border:1.5px solid var(--border); border-radius:8px; font-size:12px; font-family:'Inter',sans-serif; background:var(--white); color:var(--text); outline:none; }
        .fsel:focus { border-color:var(--teal); }

        .card { background:var(--white); border-radius:10px; border:1px solid var(--border); margin-bottom:16px; overflow:hidden; }
        .card-hd { padding:14px 20px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; background:var(--surface); }
        .card-title { font-size:13px; font-weight:600; color:var(--text); }
        .card-body { padding:20px; }

        .tbl { width:100%; border-collapse:collapse; }
        .tbl th { text-align:left; padding:10px 20px; font-size:10px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:.06em; border-bottom:1px solid var(--border); background:var(--surface); }
        .tbl td { padding:12px 20px; border-bottom:1px solid var(--border); font-size:12px; color:var(--text); vertical-align:middle; }
        .tbl tr:last-child td { border-bottom:none; }
        .tbl tr:hover td { background:var(--surface); }

        .bdg { display:inline-block; padding:3px 10px; border-radius:20px; font-size:10px; font-weight:600; }
        .bp { background:#c6f6d5; color:#276749; }
        .bt { background:#fed7d7; color:#9b2c2c; }
        .be { background:#dbeafe; color:#1e40af; }
        .bl { background:#fef3c7; color:#78350f; }
        .bn { background:#ede9fe; color:#4c1d95; }
        .br { background:#e2e8f0; color:var(--navy); }

        .btn { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:8px; font-size:12px; font-weight:600; cursor:pointer; border:none; font-family:'Inter',sans-serif; text-decoration:none; transition:all .15s; }
        .b-nv { background:var(--teal); color:#fff; }
        .b-nv:hover { background:var(--teal2); }
        .b-ol { background:transparent; color:var(--navy); border:1.5px solid var(--border); }
        .b-ol:hover { background:var(--surface); }
        .b-dn { background:#fff5f5; color:var(--err); border:1px solid #fed7d7; }
        .b-sm { padding:5px 12px; font-size:11px; border-radius:6px; }
        .td-act { display:flex; gap:5px; }

        .alert-ok { background:#f0fff4; color:#276749; padding:12px 16px; border-radius:8px; margin-bottom:16px; font-size:12px; border:1px solid #c6f6d5; font-weight:500; }
        .alert-err { background:#fff5f5; color:#9b2c2c; padding:12px 16px; border-radius:8px; margin-bottom:16px; font-size:12px; border:1px solid #fed7d7; }
        .mono { font-family:'DM Mono',monospace; font-size:11px; color:var(--teal2); }

        .fg { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
        .fgp { display:flex; flex-direction:column; gap:5px; }
        .fgp.full { grid-column:1/-1; }
        .fsec { grid-column:1/-1; font-size:13px; font-weight:700; color:var(--navy); padding:10px 0 8px; border-bottom:2px solid var(--border); margin-top:6px; text-transform:uppercase; letter-spacing:.05em; }
        label { font-size:10px; font-weight:600; color:var(--muted); text-transform:uppercase; letter-spacing:.05em; }
        .req { color:var(--err); }
        input, select { padding:9px 12px; border:1.5px solid var(--border); border-radius:8px; font-size:12px; font-family:'Inter',sans-serif; color:var(--text); outline:none; background:var(--white); transition:border .15s; }
        input:focus, select:focus { border-color:var(--teal); box-shadow:0 0 0 3px rgba(0,201,167,.1); }
        input:disabled { background:var(--surface); color:var(--muted); }
        .fa { display:flex; gap:10px; justify-content:flex-end; padding-top:20px; border-top:1px solid var(--border); margin-top:8px; grid-column:1/-1; }
        .err-msg { color:var(--err); font-size:11px; margin-top:2px; }

        .filters { display:flex; gap:10px; margin-bottom:20px; align-items:center; flex-wrap:wrap; }
        .shift-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:20px; }
        .scard { background:var(--white); border-radius:10px; border:1px solid var(--border); overflow:hidden; }
        .shd { padding:12px 16px; border-bottom:1px solid var(--border); }
        .shd.ea { border-top:4px solid #3b82f6; }
        .shd.lt { border-top:4px solid #f59e0b; }
        .shd.nt { border-top:4px solid #8b5cf6; }
        .sl { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; }
        .shd.ea .sl { color:#1e40af; }
        .shd.lt .sl { color:#78350f; }
        .shd.nt .sl { color:#4c1d95; }
        .st { font-size:10px; color:var(--muted); margin-top:2px; }
        .sbody { padding:12px 16px; display:flex; flex-direction:column; gap:8px; }
        .sp { display:flex; align-items:center; gap:10px; padding:6px 0; border-bottom:1px solid var(--border); }
        .sp:last-child { border-bottom:none; }
        .spav { width:28px; height:28px; border-radius:50%; background:var(--navy); color:#fff; display:flex; align-items:center; justify-content:center; font-size:9px; font-weight:700; flex-shrink:0; }
        .spn { font-size:12px; font-weight:500; }
        .spp { font-size:10px; color:var(--muted); }
        .sempty { text-align:center; padding:20px; color:var(--muted); font-size:11px; }
        .ward-info { background:var(--navy); border-radius:10px; padding:16px 20px; margin-bottom:20px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px; }
        .wi-title { font-size:16px; font-weight:700; color:#fff; }
        .wi-sub { font-size:11px; color:rgba(255,255,255,.6); margin-top:3px; }
        .wi-stats { display:flex; gap:24px; }
        .wi-stat { text-align:center; }
        .wi-stat-n { font-size:20px; font-weight:700; color:var(--teal); }
        .wi-stat-l { font-size:10px; color:rgba(255,255,255,.5); text-transform:uppercase; letter-spacing:.06em; margin-top:2px; }
        .add-form { background:var(--surface); border-bottom:1px solid var(--border); padding:16px 20px; display:none; }
        .add-form.show { display:block; }
        .fg-inline { display:grid; grid-template-columns:1fr 1fr 1fr 1fr auto; gap:12px; align-items:end; }
        .p-info { display:flex; align-items:center; gap:10px; }
        .p-av { width:30px; height:30px; border-radius:50%; background:var(--navy); color:#fff; display:flex; align-items:center; justify-content:center; font-size:10px; font-weight:700; flex-shrink:0; }
        .card-sub { font-size:11px; color:var(--muted); margin-top:2px; }

        .pb { background:var(--navy); border-radius:10px; padding:22px 24px; display:flex; align-items:center; gap:18px; margin-bottom:16px; }
        .pav { width:58px; height:58px; border-radius:50%; background:var(--teal); display:flex; align-items:center; justify-content:center; font-size:20px; font-weight:700; color:#fff; flex-shrink:0; }
        .pn { font-size:20px; font-weight:700; color:#fff; }
        .pr { font-size:11px; color:rgba(255,255,255,.6); margin-top:3px; text-transform:uppercase; letter-spacing:.07em; }
        .pm { display:flex; gap:14px; margin-top:10px; flex-wrap:wrap; }
        .pmi { font-size:11px; color:rgba(255,255,255,.6); }
        .pg { display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:16px; }
        .dr { display:flex; justify-content:space-between; align-items:center; padding:9px 0; border-bottom:1px solid var(--border); font-size:12px; }
        .dr:last-child { border-bottom:none; }
        .dl { color:var(--muted); font-weight:500; }
        .dv { color:var(--text); font-weight:500; }
        .tabs { display:flex; gap:2px; }
        .tab { padding:9px 16px; font-size:12px; font-weight:500; color:var(--muted); cursor:pointer; border-bottom:2px solid transparent; margin-bottom:-1px; }
        .tab.on { color:var(--navy); border-bottom-color:var(--teal); font-weight:600; }
        .stbl { width:100%; border-collapse:collapse; }
        .stbl th { background:var(--surface); color:var(--muted); font-size:10px; font-weight:700; padding:10px 20px; text-transform:uppercase; letter-spacing:.06em; border-bottom:1px solid var(--border); text-align:left; }
        .stbl td { padding:11px 20px; border-bottom:1px solid var(--border); font-size:12px; }
        .stbl tr:last-child td { border-bottom:none; }
        .inline-form { padding:14px 20px; border-bottom:1px solid var(--border); background:var(--surface); display:none; }
        .inline-form.show { display:block; }
        .if-grid { display:grid; gap:10px; align-items:end; }
        .if-grid-3 { grid-template-columns:1fr 1fr 1fr auto; }
        .if-grid-4 { grid-template-columns:1fr 1fr 1fr 1fr auto; }

        .staff-row.hidden { display:none; }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

<div class="sb">
    <div class="sb-brand">
        <div class="sb-logo">Well<span>meadows</span></div>
        <div class="sb-ver">Hospital Management System</div>
    </div>
    <div class="sb-nav">
        <div class="nav-lbl">Module 2</div>
        <a href="<?php echo e(route('staff.index')); ?>" class="ni <?php echo e(request()->routeIs('staff.index', 'staff.show', 'staff.edit') ? 'on' : ''); ?>">👥 Staff Directory</a>
        <a href="<?php echo e(route('staff.create')); ?>" class="ni <?php echo e(request()->routeIs('staff.create') ? 'on' : ''); ?>">＋ Add Staff</a>
        <a href="<?php echo e(route('ward-allocation.index')); ?>" class="ni <?php echo e(request()->routeIs('ward-allocation.*') ? 'on' : ''); ?>">📅 Ward Allocation</a>
        <div class="nav-lbl" style="margin-top:8px">System</div>
        <a href="/" class="ni">🏠 Home</a>
    </div>
    <div class="sb-footer">Module 2 — Staff &amp; Department Management</div>
</div>

<div class="main">
    <div class="topbar">
        <div>
            <div class="tb-sub">Module 2 — Staff &amp; Department Management</div>
            <div class="tb-ward"><?php echo $__env->yieldContent('top_title', 'Staff & Department Management'); ?></div>
        </div>
        <div class="tb-r">
            <span><?php echo e(date('d M Y')); ?></span>
            <div class="av">PO</div>
        </div>
    </div>

    <div class="content">
        <?php if(session('success')): ?>
            <div class="alert-ok">✓ <?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </div>
</div>

<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\crest\OneDrive\Desktop\finalpit\finalpit\finalpit\resources\views/layouts/staff.blade.php ENDPATH**/ ?>