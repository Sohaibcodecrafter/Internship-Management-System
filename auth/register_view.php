<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS — Register</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700;900&family=DM+Serif+Display&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/ims/assets/css/design-system.css">
    <link rel="stylesheet" href="/ims/assets/css/components.css">
    <style>
        .role-toggle { display:flex; gap:0; margin-bottom:var(--s4); border-radius:var(--radius-md); overflow:hidden; border:2px solid var(--accent-primary); }
        .role-toggle label { flex:1; text-align:center; padding:10px; cursor:pointer; font-weight:600; font-size:0.9rem; transition:all 0.2s ease; color:var(--accent-primary); background:transparent; }
        .role-toggle input { display:none; }
        .role-toggle input:checked + label { background:var(--accent-primary); color:#fff; }
        .field-row { display:grid; grid-template-columns:1fr 1fr; gap:var(--s2); }
        .role-fields { display:none; }
        .role-fields.active { display:block; }
    </style>
</head>
<body style="margin:0;padding:0">
<div class="auth-split">

    <!-- LEFT: Image -->
    <div class="auth-split__image" aria-hidden="true">
        <img src="/ims/assets/images/modern-geometric-building.png"
             alt="Modern Geometric Building"
             class="auth-split__img">
        <div class="auth-split__overlay">
            <div class="auth-split__tagline">
                <h2>InternBridge <em>PK</em></h2>
                <p>Connecting Pakistani talent<br>with real opportunity.</p>
            </div>
        </div>
    </div>

    <!-- RIGHT: Register Form -->
    <div class="auth-split__form">
        <div class="reg-box" style="width:100%;max-width:520px;padding:var(--s4)">
            <h1 style="font-family:'DM Serif Display',serif;font-size:1.8rem;margin-bottom:var(--s1)">Create Account</h1>
            <p style="color:var(--text-muted);font-size:0.875rem;margin-bottom:var(--s4)">Internship Management System · Join as a Student or Company</p>

            <?php if ($error): ?>
                <div class="alert alert-error"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST" action="" novalidate>
                <!-- Role Toggle -->
                <div class="role-toggle">
                    <input type="radio" name="role" id="role-student" value="student" <?= ($old['role'] ?? 'student') === 'student' ? 'checked' : '' ?>>
                    <label for="role-student">🎓 Student</label>
                    <input type="radio" name="role" id="role-company" value="company" <?= ($old['role'] ?? '') === 'company' ? 'checked' : '' ?>>
                    <label for="role-company">🏢 Company</label>
                </div>

                <!-- Common Fields -->
                <div class="input-group">
                    <label class="input-label" for="username">Username</label>
                    <input type="text" id="username" name="username" class="input-field" placeholder="Choose a username" required value="<?= htmlspecialchars($old['username'] ?? '') ?>">
                </div>
                <div class="field-row">
                    <div class="input-group">
                        <label class="input-label" for="password">Password</label>
                        <input type="password" id="password" name="password" class="input-field" placeholder="Min 8 characters" required>
                    </div>
                    <div class="input-group">
                        <label class="input-label" for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="input-field" placeholder="Re-enter password" required>
                    </div>
                </div>

                <!-- Student Fields -->
                <div id="student-fields" class="role-fields <?= ($old['role'] ?? 'student') === 'student' ? 'active' : '' ?>">
                    <div class="input-group">
                        <label class="input-label" for="full_name">Full Name</label>
                        <input type="text" id="full_name" name="full_name" class="input-field" placeholder="Ahmed Khan" value="<?= htmlspecialchars($old['full_name'] ?? '') ?>">
                    </div>
                    <div class="input-group">
                        <label class="input-label" for="email">Email</label>
                        <input type="email" id="email" name="email" class="input-field" placeholder="you@university.edu" value="<?= htmlspecialchars($old['email'] ?? '') ?>">
                    </div>
                    <div class="field-row">
                        <div class="input-group">
                            <label class="input-label" for="dept_id">Department</label>
                            <select id="dept_id" name="dept_id" class="select-field">
                                <option value="">Select Department</option>
                                <?php foreach ($departments as $d): ?>
                                    <option value="<?= $d['dept_id'] ?>" <?= (int)($old['dept_id'] ?? 0) === $d['dept_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($d['dept_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="input-group">
                            <label class="input-label" for="enrollment_year">Enrollment Year</label>
                            <input type="number" id="enrollment_year" name="enrollment_year" class="input-field" placeholder="<?= date('Y') ?>" min="2000" max="<?= date('Y') ?>" value="<?= htmlspecialchars($old['enrollment_year'] ?? date('Y')) ?>">
                        </div>
                    </div>
                    <div class="field-row">
                        <div class="input-group">
                            <label class="input-label" for="gpa">GPA (0–4.00)</label>
                            <input type="number" id="gpa" name="gpa" class="input-field" placeholder="3.50" step="0.01" min="0" max="4" value="<?= htmlspecialchars($old['gpa'] ?? '') ?>">
                        </div>
                        <div class="input-group">
                            <label class="input-label" for="phone">Phone (optional)</label>
                            <input type="text" id="phone" name="phone" class="input-field" placeholder="03XX-XXXXXXX" value="<?= htmlspecialchars($old['phone'] ?? '') ?>">
                        </div>
                    </div>
                </div>

                <!-- Company Fields -->
                <div id="company-fields" class="role-fields <?= ($old['role'] ?? '') === 'company' ? 'active' : '' ?>">
                    <div class="input-group">
                        <label class="input-label" for="company_name">Company Name</label>
                        <input type="text" id="company_name" name="company_name" class="input-field" placeholder="TechVentures Pvt Ltd" value="<?= htmlspecialchars($old['company_name'] ?? '') ?>">
                    </div>
                    <div class="field-row">
                        <div class="input-group">
                            <label class="input-label" for="industry">Industry</label>
                            <input type="text" id="industry" name="industry" class="input-field" placeholder="Software / Finance / etc." value="<?= htmlspecialchars($old['industry'] ?? '') ?>">
                        </div>
                        <div class="input-group">
                            <label class="input-label" for="reg_city">City</label>
                            <select id="reg_city" name="city" class="select-field">
                                <option value="">Select City</option>
                                <?php foreach (['Karachi','Lahore','Islamabad','Peshawar','Quetta','Multan','Faisalabad','Hyderabad'] as $c): ?>
                                    <option value="<?= $c ?>" <?= ($old['city'] ?? '') === $c ? 'selected' : '' ?>><?= $c ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="input-group">
                        <label class="input-label" for="contact_email">Contact Email</label>
                        <input type="email" id="contact_email" name="contact_email" class="input-field" placeholder="hr@company.pk" value="<?= htmlspecialchars($old['contact_email'] ?? '') ?>">
                    </div>
                    <div class="field-row">
                        <div class="input-group">
                            <label class="input-label" for="contact_phone">Phone (optional)</label>
                            <input type="text" id="contact_phone" name="contact_phone" class="input-field" placeholder="021-XXXXXXX" value="<?= htmlspecialchars($old['contact_phone'] ?? '') ?>">
                        </div>
                        <div class="input-group">
                            <label class="input-label" for="established_year">Established Year</label>
                            <input type="number" id="established_year" name="established_year" class="input-field" placeholder="2010" value="<?= htmlspecialchars($old['established_year'] ?? '') ?>">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:var(--s3)">
                    Create Account →
                </button>
            </form>

            <p style="text-align:center;margin-top:var(--s3);font-size:0.85rem;color:var(--text-muted)">Already have an account? <a href="/ims/auth/login.php" style="color:var(--accent-primary);font-weight:600">Sign In</a></p>
        </div>
    </div>

</div>

<script>
document.querySelectorAll('input[name="role"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
        document.getElementById('student-fields').classList.toggle('active', this.value === 'student');
        document.getElementById('company-fields').classList.toggle('active', this.value === 'company');
    });
});
</script>
</body>
</html>
