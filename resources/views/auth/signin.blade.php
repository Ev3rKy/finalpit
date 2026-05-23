<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wellmeadows Hospital — Sign In</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root { --navy: #1e2a4a; --cream: #f0ece3; --beige: #e8dfc8; --white: #ffffff; }
        body {
            font-family: 'Jost', sans-serif;
            background: var(--cream);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .auth-box { width: 340px; text-align: center; }
        .auth-brand {
            font-family: 'Cinzel', serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 36px;
        }
        .form-label {
            display: block;
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--navy);
            margin-bottom: 6px;
            text-align: left;
        }
        .form-input {
            width: 100%;
            padding: 10px 12px;
            border: 1.5px solid #ddd6c8;
            border-radius: 6px;
            font-family: 'Jost', sans-serif;
            font-size: 0.88rem;
            color: var(--navy);
            background: var(--white);
            outline: none;
            margin-bottom: 16px;
            transition: border-color 0.2s;
        }
        .form-input:focus { border-color: var(--navy); }
        .btn-primary {
            background: var(--navy);
            color: var(--white);
            border: none;
            padding: 10px 32px;
            border-radius: 8px;
            font-family: 'Jost', sans-serif;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            cursor: pointer;
            margin-top: 8px;
            width: 100%;
        }
        .btn-primary:hover { background: #2c3e6b; }
        .error-msg {
            background: #fee2e2;
            color: #991b1b;
            padding: 9px 14px;
            border-radius: 6px;
            font-size: 0.8rem;
            margin-bottom: 16px;
            text-align: left;
        }
    </style>
</head>
<body>
<div class="auth-box">
    <div class="auth-brand">Wellmeadows Hospital</div>
 
    @if($errors->any())
        <div class="error-msg">{{ $errors->first() }}</div>
    @endif
 
    <form method="POST" action="{{ route('signin.post') }}">
        @csrf
        <label class="form-label">Staff Full Name</label>
        <input class="form-input" type="text" name="full_name" value="{{ old('full_name') }}" required>
 
        <label class="form-label">Staff ID</label>
        <input class="form-input" type="text" name="staff_id_code" value="{{ old('staff_id_code') }}" required>
 
        <label class="form-label">Email Acc.</label>
        <input class="form-input" type="email" name="email" value="{{ old('email') }}" required>
 
        <label class="form-label">Set Password</label>
        <input class="form-input" type="password" name="password" required>
 
        <label class="form-label">Confirm Password</label>
        <input class="form-input" type="password" name="password_confirmation" required>
 
        <button class="btn-primary" type="submit">Log In</button>
    </form>
</div>
</body>
</html>
