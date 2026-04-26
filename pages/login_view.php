<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS — Login</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/ims/assets/css/design-system.css">
    <link rel="stylesheet" href="/ims/assets/css/components.css">
    <style>
        body { display:flex; align-items:center; justify-content:center; min-height:100vh; background:var(--bg-base); }
        .login-box { width:100%; max-width:420px; padding:var(--s5); }
        .login-title { font-family:'DM Serif Display',serif; font-size:2rem; margin-bottom:var(--s1); }
        .login-sub { color:var(--text-muted); font-size:0.875rem; margin-bottom:var(--s5); }
    </style>
</head>
<body>
<div class="card login-box">
    <h1 class="login-title">Welcome Back</h1>
    <p class="login-sub">Internship Management System · Sign in to continue</p>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-<?= $_SESSION['flash']['type'] === 'success' ? 'success' : 'error' ?>">
            <?= htmlspecialchars($_SESSION['flash']['msg']) ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="" id="loginForm" novalidate>
        <div class="input-group">
            <label class="input-label" for="username">Username</label>
            <input type="text" id="username" name="username" class="input-field" placeholder="Enter your username" required autocomplete="username">
            <span class="error-msg" id="err-username"></span>
        </div>
        <div class="input-group">
            <label class="input-label" for="password">Password</label>
            <input type="password" id="password" name="password" class="input-field" placeholder="••••••••" required autocomplete="current-password">
            <span class="error-msg" id="err-password"></span>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:var(--s2)">
            Sign In →
        </button>
    </form>
    <p style="text-align:center;margin-top:var(--s3);font-size:0.85rem;color:var(--text-muted)">
        Don't have an account? <a href="/ims/auth/register.php" style="color:var(--accent-primary);font-weight:600">Register</a>
    </p>
</div>
<script src="/ims/assets/js/main.js"></script>
</body>
</html>
