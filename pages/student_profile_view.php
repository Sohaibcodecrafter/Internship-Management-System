<?php if ($success): ?><div class="alert alert-success"><?= htmlspecialchars($success) ?></div><?php endif; ?>
<?php if ($error): ?><div class="alert alert-error"><?= $error ?></div><?php endif; ?>

<div class="page-header"><div><h1 class="page-title">My Profile</h1><p class="page-subtitle">Update your information and upload documents</p></div></div>

<form method="POST" enctype="multipart/form-data" class="bento-grid">
    <div class="card bento-8">
        <h3 style="font-size:1rem;font-weight:600;margin-bottom:var(--s3)">Personal Information</h3>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--s2)">
            <div class="input-group">
                <label class="input-label">Username</label>
                <input type="text" class="input-field" value="<?= htmlspecialchars($student['username']) ?>" disabled>
            </div>
            <div class="input-group">
                <label class="input-label" for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" class="input-field" value="<?= htmlspecialchars($student['full_name']) ?>" required>
            </div>
            <div class="input-group">
                <label class="input-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="input-field" value="<?= htmlspecialchars($student['email']) ?>" required>
            </div>
            <div class="input-group">
                <label class="input-label" for="phone">Phone</label>
                <input type="text" id="phone" name="phone" class="input-field" value="<?= htmlspecialchars($student['phone'] ?? '') ?>" placeholder="03XX-XXXXXXX">
            </div>
            <div class="input-group">
                <label class="input-label" for="dept_id">Department</label>
                <select id="dept_id" name="dept_id" class="select-field" required>
                    <?php foreach ($departments as $d): ?>
                        <option value="<?= $d['dept_id'] ?>" <?= $student['dept_id'] == $d['dept_id'] ? 'selected' : '' ?>><?= htmlspecialchars($d['dept_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input-group">
                <label class="input-label" for="enrollment_year">Enrollment Year</label>
                <input type="number" id="enrollment_year" name="enrollment_year" class="input-field" value="<?= $student['enrollment_year'] ?>" min="2000" max="<?= date('Y') ?>">
            </div>
            <div class="input-group">
                <label class="input-label" for="gpa">GPA</label>
                <input type="number" id="gpa" name="gpa" class="input-field" step="0.01" min="0" max="4" value="<?= $student['gpa'] ?>">
            </div>
        </div>
    </div>

    <div class="card bento-4">
        <h3 style="font-size:1rem;font-weight:600;margin-bottom:var(--s3)">Documents</h3>
        <div class="input-group">
            <label class="input-label">CV (PDF/DOCX, max 2MB)</label>
            <input type="file" name="cv_file" class="input-field" accept=".pdf,.doc,.docx">
            <?php if ($student['cv_file']): ?>
                <a href="/ims/assets/uploads/cvs/<?= htmlspecialchars($student['cv_file']) ?>" target="_blank" style="font-size:0.8rem;color:var(--accent-primary);margin-top:4px;display:inline-block">
                    📄 <?= htmlspecialchars($student['cv_file']) ?>
                </a>
            <?php endif; ?>
        </div>
        <div class="input-group" style="margin-top:var(--s3)">
            <label class="input-label">Profile Photo (JPG/PNG, max 1MB)</label>
            <input type="file" name="profile_pic" class="input-field" accept=".jpg,.jpeg,.png">
            <?php if (!empty($student['profile_pic'])): ?>
                <img src="/ims/assets/uploads/photos/<?= htmlspecialchars($student['profile_pic']) ?>" alt="Profile" style="width:80px;height:80px;border-radius:50%;object-fit:cover;margin-top:8px">
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:var(--s3)">Save Profile</button>
    </div>
</form>
