<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS — Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700;900&family=DM+Serif+Display&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/design-system.css">
    <link rel="stylesheet" href="/assets/css/components.css">
    <style>
        .input-field, .select-field { color: black !important; }
    </style>
</head>
<body style="margin:0;padding:0">
<a href="/" class="btn btn-ghost" style="position:absolute; top:20px; left:20px; z-index:100; min-height:44px; display:flex; align-items:center; gap:8px; background:rgba(255,255,255,0.1); backdrop-filter:blur(10px); border:1px solid rgba(255,255,255,0.2);">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
    Back to Home
</a>
<div class="auth-split">

    <!-- LEFT: Image -->
    <div class="auth-split__image" aria-hidden="true">
        <img src="/assets/images/modern-geometric-building.png"
             alt="Modern Geometric Building"
             class="auth-split__img">
        <div class="auth-split__overlay">
            <div class="auth-split__tagline">
                <h2>InternBridge <em>PK</em></h2>
                <p>Connecting Pakistani talent<br>with real opportunity.</p>
            </div>
        </div>
    </div>

    <!-- RIGHT: Login Form -->
    <div class="auth-split__form">
        <div class="login-box" style="width:100%;max-width:420px">
            <h1 style="font-family:'DM Serif Display',serif;font-size:2rem;margin-bottom:var(--s1)">Welcome Back</h1>
            <p style="color:var(--text-muted);font-size:0.875rem;margin-bottom:var(--s5)">Internship Management System · Sign in to continue</p>

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
                Don't have an account? <a href="/auth/register.php" style="color:var(--accent-primary);font-weight:600">Register</a>
            </p>
        </div>
    </div>

</div>
<script src="/assets/js/main.js"></script>
</body>
</html>
