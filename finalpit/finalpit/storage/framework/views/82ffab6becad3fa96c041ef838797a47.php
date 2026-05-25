<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Registration — Wellmeadows</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: linear-gradient(160deg, #1a2557, #232d6b); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px; }
        .card { background: #fff; border-radius: 20px; max-width: 440px; width: 100%; padding: 40px 36px; box-shadow: 0 24px 60px rgba(0,0,0,.35); }
        h1 { font-size: 1.5rem; color: #1a2557; margin-bottom: 6px; }
        h1 span { color: #00c9a7; }
        .sub { font-size: .8rem; color: #64748b; margin-bottom: 20px; line-height: 1.5; }
        label { display: block; font-size: .65rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: .1em; margin-bottom: 6px; }
        select, input { width: 100%; padding: 12px 14px; border: 1.5px solid #e2e8f0; border-radius: 10px; margin-bottom: 16px; font-family: inherit; font-size: .9rem; }
        select:focus, input:focus { outline: none; border-color: #00c9a7; }
        .btn { width: 100%; padding: 14px; background: #00c9a7; color: #fff; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; text-transform: uppercase; font-size: .8rem; }
        .btn:hover { background: #00b096; }
        .back { display: block; text-align: center; margin-top: 16px; font-size: .8rem; color: #00b096; text-decoration: none; }
        .alert-err { background: #fff5f5; color: #c92a2a; padding: 10px; border-radius: 8px; margin-bottom: 14px; font-size: .85rem; }
        .hint { font-size: .72rem; color: #94a3b8; margin-top: -10px; margin-bottom: 16px; }
        .role-note { font-size: .75rem; color: #64748b; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 12px; margin-bottom: 16px; line-height: 1.5; }
    </style>
</head>
<body>
<div class="card">
    <h1>Well<span>meadows</span></h1>
    <p class="sub">Create your staff portal account. Administrators are set up by hospital IT only.</p>
    <?php if($errors->any()): ?><div class="alert-err"><?php echo e($errors->first()); ?></div><?php endif; ?>
    <form method="POST" action="<?php echo e(route('register.post')); ?>">
        <?php echo csrf_field(); ?>
        <label>Your role</label>
        <select name="role" id="reg_role" required onchange="updateRegHints()">
            <option value="">Select role…</option>
            <?php $__currentLoopData = $registerableRoles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $meta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($key); ?>" <?php echo e(old('role') === $key ? 'selected' : ''); ?>><?php echo e($meta['label']); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <div class="role-note" id="role_note">Choose a role to see what access you will receive.</div>
        <label>Full name</label>
        <input type="text" name="full_name" value="<?php echo e(old('full_name')); ?>" required>
        <label>Staff badge ID</label>
        <input type="text" name="staff_id_code" id="staff_id_code" value="<?php echo e(old('staff_id_code')); ?>" placeholder="e.g. DOC002, NUR002, BIL002" required>
        <p class="hint" id="badge_hint">Use the ID format issued by HR (e.g. DOC001 for doctors).</p>
        <label>Department</label>
        <input type="text" name="department" id="department" value="<?php echo e(old('department')); ?>" placeholder="e.g. General Medicine">
        <button type="submit" class="btn">Create account</button>
    </form>
    <a href="<?php echo e(route('login')); ?>" class="back">← Back to sign in</a>
</div>
<script>
const roleMeta = <?php echo json_encode($registerableRoles, 15, 512) ?>;
function updateRegHints() {
    const role = document.getElementById('reg_role').value;
    const note = document.getElementById('role_note');
    const hint = document.getElementById('badge_hint');
    const dept = document.getElementById('department');
    if (!role || !roleMeta[role]) {
        note.textContent = 'Choose a role to see what access you will receive.';
        return;
    }
    const m = roleMeta[role];
    note.textContent = m.description;
    hint.textContent = m.badge_hint;
    if (m.default_department) dept.placeholder = m.default_department;
}
updateRegHints();
</script>
</body>
</html>
<?php /**PATH C:\Users\pausa\Downloads\V.2\finalpit\finalpit\finalpit\resources\views/auth/register.blade.php ENDPATH**/ ?>