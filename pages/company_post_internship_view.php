<?php if (!empty($blocked)): ?>
<div class="card" style="text-align:center;padding:3rem;max-width:600px;margin:0 auto">
    <div style="font-size:3rem;margin-bottom:1rem">🔒</div>
    <h2 style="color:var(--text-primary)">Account Not Verified</h2>
    <p style="color:var(--text-muted);margin:1rem 0">
        Your company account must be verified by an admin before you can post internships.
    </p>
    <?php if (!empty($requested)): ?>
        <div class="badge" style="background:var(--accent-warning);color:#fff;padding:0.5rem 1.5rem;font-size:0.9rem">
            ⏳ Verification request sent — awaiting admin review
        </div>
    <?php else: ?>
        <form method="POST" action="company_request_verification.php">
            <button type="submit" class="btn btn-primary" style="margin-top:1rem">📨 Request Verification</button>
        </form>
    <?php endif; ?>
</div>
<?php else: ?>

<?php if ($error): ?><div class="alert alert-error"><?= $error ?></div><?php endif; ?>
<div class="page-header"><div><h1 class="page-title">Post New Internship</h1><p class="page-subtitle">Fill in the details for your internship listing</p></div></div>

<div class="card" style="max-width:700px">
    <form method="POST" data-validate="true">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--s2)">
            <div class="input-group" style="grid-column:1/-1">
                <label class="input-label" for="title">Title *</label>
                <input type="text" id="title" name="title" class="input-field" placeholder="e.g. Frontend Developer Intern" required value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">
                <span class="error-msg" id="err-title"></span>
            </div>
            <div class="input-group" style="grid-column:1/-1">
                <label class="input-label" for="description">Description</label>
                <textarea id="description" name="description" class="input-field" rows="4" placeholder="Job responsibilities, requirements..."><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
            </div>
            <div class="input-group">
                <label class="input-label" for="domain">Domain / Skills *</label>
                <input type="text" id="domain" name="domain" class="input-field" placeholder="Web Dev, Python, Data Analysis" required value="<?= htmlspecialchars($_POST['domain'] ?? '') ?>">
                <span class="error-msg" id="err-domain"></span>
            </div>
            <div class="input-group">
                <label class="input-label" for="stipend">Stipend (PKR/month)</label>
                <input type="number" id="stipend" name="stipend" class="input-field" placeholder="0 for unpaid" min="0" value="<?= htmlspecialchars($_POST['stipend'] ?? '0') ?>">
            </div>
            <div class="input-group">
                <label class="input-label" for="duration_months">Duration (months) *</label>
                <input type="number" id="duration_months" name="duration_months" class="input-field" min="1" max="12" required value="<?= htmlspecialchars($_POST['duration_months'] ?? '3') ?>">
                <span class="error-msg" id="err-duration_months"></span>
            </div>
            <div class="input-group">
                <label class="input-label" for="slots">Available Slots</label>
                <input type="number" id="slots" name="slots" class="input-field" min="1" value="<?= htmlspecialchars($_POST['slots'] ?? '1') ?>">
            </div>
            <div class="input-group">
                <label class="input-label" for="start_date">Start Date *</label>
                <input type="date" id="start_date" name="start_date" class="input-field" required value="<?= htmlspecialchars($_POST['start_date'] ?? '') ?>">
            </div>
            <div class="input-group">
                <label class="input-label" for="end_date">End Date *</label>
                <input type="date" id="end_date" name="end_date" class="input-field" required value="<?= htmlspecialchars($_POST['end_date'] ?? '') ?>">
            </div>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:var(--s3)">Post Internship →</button>
    </form>
</div>
<?php endif; ?>
