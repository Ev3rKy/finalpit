<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Wellmeadows'); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy:#1a2557; --teal:#00c9a7; --teal2:#00b096;
            --bg:#f0f2f5; --cream:#f5f0e8; --white:#ffffff; --border:#e2e8f0;
            --text:#1e293b; --muted:#64748b; --err:#e53e3e;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',sans-serif; background:var(--cream); color:var(--text); font-size:13px; min-height:100vh; display:flex; }
        .sb { width:220px; background:var(--navy); display:flex; flex-direction:column; flex-shrink:0; min-height:100vh; position:fixed; left:0; top:0; bottom:0; z-index:40; }
        .sb-brand { padding:20px 18px 16px; border-bottom:1px solid rgba(255,255,255,.08); }
        .sb-logo { font-size:18px; font-weight:700; color:#fff; }
        .sb-logo span { color:var(--teal); }
        .sb-nav { padding:16px 0; flex:1; overflow-y:auto; }
        .nav-lbl { padding:8px 18px 4px; font-size:9px; font-weight:600; color:rgba(255,255,255,.3); text-transform:uppercase; letter-spacing:.12em; }
        .ni { display:flex; align-items:center; gap:10px; padding:10px 18px; color:rgba(255,255,255,.6); font-size:12px; text-decoration:none; transition:all .15s; border-left:3px solid transparent; }
        .ni:hover { background:rgba(255,255,255,.07); color:#fff; }
        .ni.on { background:rgba(0,201,167,.1); color:var(--teal); border-left-color:var(--teal); font-weight:500; }
        .sb-footer { padding:14px 18px; border-top:1px solid rgba(255,255,255,.08); font-size:10px; color:rgba(255,255,255,.3); }
        .shell { margin-left:220px; flex:1; display:flex; flex-direction:column; min-height:100vh; }
        .topbar { background:var(--navy); padding:0 28px; display:flex; align-items:center; justify-content:space-between; height:60px; flex-shrink:0; }
        .tb-page { font-size:14px; font-weight:700; color:#fff; text-transform:uppercase; letter-spacing:.08em; }
        .tb-r { display:flex; align-items:center; gap:14px; flex-wrap:wrap; }
        .tb-date { font-size:12px; color:rgba(255,255,255,.6); }
        .content { flex:1; padding:24px 28px; overflow-y:auto; }
        .stats { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:22px; }
        .stat { background:var(--white); border-radius:10px; padding:18px 20px; border:1px solid var(--border); }
        .stat.navy { background:var(--navy); border-color:var(--navy); }
        .stat.teal { background:var(--teal); border-color:var(--teal); }
        .stat.outline { border:2px solid var(--teal); }
        .stat-l { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:var(--muted); }
        .stat.navy .stat-l, .stat.teal .stat-l { color:rgba(255,255,255,.7); }
        .stat-n { font-size:28px; font-weight:700; margin:6px 0 4px; }
        .stat.navy .stat-n, .stat.teal .stat-n { color:#fff; }
        .stat-s { font-size:11px; color:var(--muted); }
        .stat.navy .stat-s, .stat.teal .stat-s { color:rgba(255,255,255,.6); }
        .card { background:var(--white); border-radius:10px; border:1px solid var(--border); margin-bottom:16px; overflow:hidden; }
        .card-hd { padding:16px 20px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; }
        .card-title { font-size:14px; font-weight:600; color:var(--navy); }
        .card-sub { font-size:11px; color:var(--muted); margin-top:2px; }
        .tbl { width:100%; border-collapse:collapse; }
        .tbl th { text-align:left; padding:10px 20px; font-size:10px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:.07em; border-bottom:1px solid var(--border); background:#f8fafc; }
        .tbl td { padding:13px 20px; border-bottom:1px solid var(--border); font-size:12px; vertical-align:middle; }
        .tbl tr:last-child td { border-bottom:none; }
        .tbl tr:hover td { background:#f8fafc; }
        .p-info { display:flex; align-items:center; gap:10px; }
        .p-av { width:32px; height:32px; border-radius:50%; background:var(--navy); color:#fff; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; flex-shrink:0; }
        .bdg { display:inline-block; padding:3px 10px; border-radius:20px; font-size:10px; font-weight:600; }
        .bp { background:#c6f6d5; color:#276749; }
        .bo { background:#feebc8; color:#9c4221; }
        .br { background:#fed7d7; color:#9b2c2c; }
        .bb { background:#e6fffa; color:#234e52; font-family:'DM Mono',monospace; padding:3px 8px; border-radius:6px; }
        .btn { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:8px; font-size:12px; font-weight:600; cursor:pointer; border:none; font-family:'Inter',sans-serif; text-decoration:none; transition:all .15s; }
        .b-teal { background:var(--teal); color:#fff; }
        .b-teal:hover { background:var(--teal2); }
        .b-nv { background:var(--navy); color:#fff; }
        .b-ol { background:transparent; color:var(--navy); border:1.5px solid var(--border); }
        .b-dn { background:#fff5f5; color:var(--err); border:1px solid #fed7d7; }
        .b-sm { padding:5px 12px; font-size:11px; border-radius:6px; }
        .td-act { display:flex; gap:6px; align-items:center; flex-wrap:wrap; }
        .alert-ok { background:#f0fff4; color:#276749; padding:12px 16px; border-radius:8px; margin-bottom:16px; font-size:12px; border:1px solid #c6f6d5; }
        .alert-err { background:#fff5f5; color:#9b2c2c; padding:12px 16px; border-radius:8px; margin-bottom:16px; font-size:12px; border:1px solid #fed7d7; }
        .sinp { padding:9px 14px; border:1.5px solid var(--border); border-radius:8px; font-size:12px; font-family:'Inter',sans-serif; }
        .sinp:focus { outline:none; border-color:var(--teal); }
        .mono { font-family:'DM Mono',monospace; font-size:11px; color:var(--teal2); }
        .grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
        .modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.5); align-items:center; justify-content:center; z-index:100; }
        .modal-overlay.active { display:flex; }
        .modal { background:#fff; padding:24px; border-radius:12px; width:min(600px,94vw); max-height:90vh; overflow:auto; }
        .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
        .form-grid .full { grid-column:1/-1; }
        .form-grid label { display:flex; flex-direction:column; gap:5px; font-size:10px; font-weight:600; color:var(--muted); text-transform:uppercase; }
        .form-grid input, .form-grid select, .form-grid textarea { padding:9px 12px; border:1.5px solid var(--border); border-radius:8px; font-size:12px; font-family:'Inter',sans-serif; }
        .act-link { font-size:11px; font-weight:600; text-decoration:none; color:var(--teal2); }
        .act-del { color:var(--err); background:none; border:none; cursor:pointer; font-size:11px; font-weight:600; }
        nav[role="navigation"] { padding:16px 20px; font-size:12px; }
        nav[role="navigation"] a, nav[role="navigation"] span { color:var(--teal2); margin:0 4px; }
        @media(max-width:900px){ .stats,.grid-2{ grid-template-columns:1fr; } .shell{ margin-left:180px; } .sb{ width:180px; } }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
<div class="sb">
    <div class="sb-brand"><div class="sb-logo">Well<span>meadows</span></div></div>
    <div class="sb-nav">
        <?php echo $__env->yieldContent('sidebar'); ?>
        <div class="nav-lbl" style="margin-top:12px">System</div>
        <a href="<?php echo e(route('dashboard')); ?>" class="ni">Dashboard</a>
        <form method="POST" action="<?php echo e(route('logout')); ?>" style="margin:0">
            <?php echo csrf_field(); ?>
            <button type="submit" class="ni" style="width:100%;background:none;border:none;cursor:pointer;text-align:left;font-family:inherit">Sign Out</button>
        </form>
    </div>
    <div class="sb-footer">Wellmeadows v1.0</div>
</div>
<div class="shell">
    <div class="topbar">
        <div class="tb-page"><?php echo $__env->yieldContent('page_title', 'Module'); ?></div>
        <div class="tb-r">
            <span class="tb-date"><?php echo e(date('d M Y')); ?></span>
            <?php echo $__env->yieldContent('top_actions'); ?>
        </div>
    </div>
    <div class="content">
        <?php if(session('success')): ?><div class="alert-ok"><?php echo e(session('success')); ?></div><?php endif; ?>
        <?php if(session('error')): ?><div class="alert-err"><?php echo e(session('error')); ?></div><?php endif; ?>
        <?php if($errors->any()): ?><div class="alert-err"><?php echo e($errors->first()); ?></div><?php endif; ?>
        <?php echo $__env->yieldContent('content'); ?>
    </div>
</div>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\crest\OneDrive\Desktop\finalpit\finalpit\finalpit\resources\views/layouts/module.blade.php ENDPATH**/ ?>