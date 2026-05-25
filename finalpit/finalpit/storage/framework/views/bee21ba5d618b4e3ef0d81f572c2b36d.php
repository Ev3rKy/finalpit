<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wellmeadows Hospital — Staff Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(160deg, #1a2557 0%, #232d6b 50%, #1a2557 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .card {
            background: #fff;
            border-radius: 20px;
            width: 100%;
            max-width: 440px;
            padding: 40px 36px;
            box-shadow: 0 24px 60px rgba(0,0,0,.35);
        }
        .brand { text-align: center; margin-bottom: 32px; }
        .brand h1 { font-size: 1.75rem; color: #1a2557; font-weight: 700; }
        .brand h1 span { color: #00c9a7; }
        .brand p { font-size: .7rem; color: #888; margin-top: 8px; text-transform: uppercase; letter-spacing: .14em; }
        label { display: block; font-size: .65rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: .1em; margin-bottom: 8px; }
        select, input {
            width: 100%;
            padding: 14px 16px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: .95rem;
            font-family: inherit;
            margin-bottom: 20px;
        }
        select:focus, input:focus { outline: none; border-color: #00c9a7; }
        .btn {
            width: 100%;
            padding: 14px;
            background: #00c9a7;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: .8rem;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: .08em;
        }
        .btn:hover { background: #00b096; }
        .alert { padding: 12px 14px; border-radius: 8px; font-size: .85rem; margin-bottom: 16px; }
        .alert-error { background: #fff5f5; color: #c92a2a; border: 1px solid #ffc9c9; }
        .alert-success { background: #f0fff4; color: #276749; border: 1px solid #c6f6d5; }
        .footer { margin-top: 24px; text-align: center; font-size: .8rem; color: #64748b; }
        .footer a { color: #00b096; font-weight: 600; text-decoration: none; }
        .hint { font-size: .72rem; color: #94a3b8; margin-top: -12px; margin-bottom: 20px; }
    </style>
</head>
<body>
<div class="card">
    <div class="brand">
        <h1>Well<span>meadows</span></h1>
        <p>Hospital Management System</p>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if($errors->any()): ?>
        <div class="alert alert-error"><?php echo e($errors->first()); ?></div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('login.post')); ?>">
        <?php echo csrf_field(); ?>
        <label for="role">Your role</label>
        <select id="role" name="role" required>
            <option value="">Select role…</option>
            <option value="admin" <?php echo e(old('role') === 'admin' ? 'selected' : ''); ?>>Administrator</option>
            <option value="doctor" <?php echo e(old('role') === 'doctor' ? 'selected' : ''); ?>>Doctor</option>
            <option value="nurse" <?php echo e(old('role') === 'nurse' ? 'selected' : ''); ?>>Nurse</option>
            <option value="billing" <?php echo e(old('role') === 'billing' ? 'selected' : ''); ?>>Billing / Cashier</option>
        </select>

        <label for="staff_id_code">Staff badge ID</label>
        <input type="text" id="staff_id_code" name="staff_id_code" value="<?php echo e(old('staff_id_code')); ?>" placeholder="e.g. DOC001" required autofocus>
        <p class="hint">Scan or enter your hospital-issued staff badge number.</p>

        <button type="submit" class="btn">Enter system</button>
    </form>

    <div class="footer">
        New staff member? <a href="<?php echo e(route('register')); ?>">Register your account</a>
        <p style="margin-top:8px;font-size:.7rem;color:#94a3b8">Doctor, nurse, or billing — admin accounts are created by IT only.</p>
    </div>
</div>
</body>
</html>
<?php /**PATH C:\Users\pausa\Downloads\V.2\finalpit\finalpit\finalpit\resources\views/auth/login.blade.php ENDPATH**/ ?>