<?php if (isset($_SESSION['flash'])): ?>
    <div class="alert alert-<?= $_SESSION['flash']['type'] ?>"><?= htmlspecialchars($_SESSION['flash']['msg']) ?></div>
    <?php unset($_SESSION['flash']); endif; ?>

<div class="page-header"><div><h1 class="page-title">Applicants</h1><p class="page-subtitle"><?= count($applicants) ?> applications</p></div></div>

<!-- Filters -->
<div class="card" style="margin-bottom:var(--s3);padding:var(--s3)">
    <form method="GET" style="display:flex;gap:var(--s2);flex-wrap:wrap;align-items:flex-end">
        <div class="input-group" style="flex:1;min-width:180px">
            <label class="input-label">Internship</label>
            <select name="internship_id" class="select-field">
                <option value="">All Internships</option>
                <?php foreach ($myInternships as $mi): ?>
                    <option value="<?= $mi['internship_id'] ?>" <?= ($_GET['internship_id'] ?? '') == $mi['internship_id'] ? 'selected' : '' ?>><?= htmlspecialchars($mi['title']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="input-group" style="flex:1;min-width:140px">
            <label class="input-label">Status</label>
            <select name="status" class="select-field">
                <option value="">All Statuses</option>
                <?php foreach (['pending','shortlisted','accepted','rejected'] as $s): ?>
                    <option value="<?= $s ?>" <?= ($_GET['status'] ?? '') === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>
</div>

<div class="card">
    <div class="table-wrapper">
        <table class="data-table">
            <thead><tr><th>Student</th><th>Department</th><th>Internship</th><th>Applied</th><th>Status</th><th>CV</th><th>Action</th></tr></thead>
            <tbody>
            <?php foreach ($applicants as $a):
                $cls = match($a['status']) { 'accepted'=>'success','pending'=>'warning','rejected'=>'danger','shortlisted'=>'primary', default=>'neutral' };
            ?>
            <tr>
                <td data-label="Student">
                    <div style="font-weight:500"><?= htmlspecialchars($a['full_name']) ?></div>
                    <div style="font-size:0.75rem;color:var(--text-muted)"><?= htmlspecialchars($a['email']) ?></div>
                </td>
                <td data-label="Department" style="font-size:0.85rem"><?= htmlspecialchars($a['dept_name'] ?? '—') ?></td>
                <td data-label="Internship"><?= htmlspecialchars($a['internship_title']) ?></td>
                <td data-label="Applied" style="font-size:0.8rem;color:var(--text-muted)"><?= date('d M Y', strtotime($a['applied_at'])) ?></td>
                <td data-label="Status"><span class="badge badge-<?= $cls ?>"><?= ucfirst($a['status']) ?></span></td>
                <td data-label="CV">
                    <?php if ($a['cv_file']): ?>
                        <a href="/assets/uploads/cvs/<?= htmlspecialchars($a['cv_file']) ?>" target="_blank" class="btn btn-ghost btn-sm"><?= icon('file-text', 15) ?> View</a>
                    <?php else: ?>
                        <span style="color:var(--text-muted);font-size:0.8rem">None</span>
                    <?php endif; ?>
                </td>
                <td data-label="Action">
                    <form method="POST" style="display:flex;gap:4px;align-items:center">
                        <input type="hidden" name="application_id" value="<?= $a['application_id'] ?>">
                        <select name="new_status" class="select-field" style="min-width:120px;padding:4px 8px;font-size:0.8rem">
                            <?php foreach (['pending','shortlisted','accepted','rejected'] as $s): ?>
                                <option value="<?= $s ?>" <?= $a['status'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" name="update_status" class="btn btn-primary btn-sm">Update</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($applicants)): ?><tr><td colspan="7" style="text-align:center;color:var(--text-muted);padding:var(--s4)">No applications found.</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
