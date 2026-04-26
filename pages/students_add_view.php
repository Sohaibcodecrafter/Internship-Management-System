<div class="page-header">
    <div>
        <h1 class="page-title">Add Student</h1>
        <p class="page-subtitle">Register a new student in the system</p>
    </div>
    <a href="students.php" class="btn btn-ghost btn-sm">← Back to Students</a>
</div>

<?php if ($success): ?>
    <div class="alert alert-success">Student registered successfully!</div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-error">
        <?php foreach ($errors as $e): ?>
            <div><?= htmlspecialchars($e) ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="card" style="max-width:680px">
    <form method="POST" action="" data-validate="true" novalidate>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--s3)">
            <div class="input-group">
                <label class="input-label" for="username">Username</label>
                <input type="text" id="username" name="username" class="input-field" placeholder="e.g. new_student" required>
                <span class="error-msg" id="err-username"></span>
            </div>
            <div class="input-group">
                <label class="input-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="input-field" placeholder="Min 6 characters" required>
                <span class="error-msg" id="err-password"></span>
            </div>
        </div>

        <div class="input-group">
            <label class="input-label" for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" class="input-field" placeholder="e.g. Ali Hassan" required>
            <span class="error-msg" id="err-full_name"></span>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--s3)">
            <div class="input-group">
                <label class="input-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="input-field" placeholder="student@university.edu" required>
                <span class="error-msg" id="err-email"></span>
            </div>
            <div class="input-group">
                <label class="input-label" for="phone">Phone</label>
                <input type="text" id="phone" name="phone" class="input-field" placeholder="03001234567">
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:var(--s3)">
            <div class="input-group">
                <label class="input-label" for="dept_id">Department</label>
                <select id="dept_id" name="dept_id" class="select-field" required>
                    <option value="">Select…</option>
                    <?php foreach ($departments as $d): ?>
                    <option value="<?= $d['dept_id'] ?>"><?= htmlspecialchars($d['dept_name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="error-msg" id="err-dept_id"></span>
            </div>
            <div class="input-group">
                <label class="input-label" for="gpa">GPA</label>
                <input type="number" step="0.01" min="0" max="4" id="gpa" name="gpa" class="input-field" placeholder="3.50" required>
                <span class="error-msg" id="err-gpa"></span>
            </div>
            <div class="input-group">
                <label class="input-label" for="enrollment_year">Enrollment Year</label>
                <input type="number" min="2000" max="2030" id="enrollment_year" name="enrollment_year" class="input-field" value="<?= date('Y') ?>" required>
                <span class="error-msg" id="err-enrollment_year"></span>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="margin-top:var(--s3)">Register Student</button>
    </form>
</div>
