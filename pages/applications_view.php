<div class="page-header">
    <div>
        <h1 class="page-title">Applications</h1>
        <p class="page-subtitle">Track all student applications</p>
    </div>
</div>

<form method="GET" action="" id="filterForm">
    <div class="filter-bar">
        <div class="search-bar">
            <span class="search-icon">🔍</span>
            <input type="text" name="search" class="live-search"
                   value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                   placeholder="Search student, internship, company...">
        </div>
        <select name="status" class="select-field" style="width:180px;" onchange="this.form.submit()">
            <option value="">All Statuses</option>
            <option value="pending" <?= ($_GET['status']??'')==='pending'?'selected':'' ?>>Pending</option>
            <option value="shortlisted" <?= ($_GET['status']??'')==='shortlisted'?'selected':'' ?>>Shortlisted</option>
            <option value="accepted" <?= ($_GET['status']??'')==='accepted'?'selected':'' ?>>Accepted</option>
            <option value="rejected" <?= ($_GET['status']??'')==='rejected'?'selected':'' ?>>Rejected</option>
        </select>
        <a href="?" class="btn btn-ghost btn-sm">Clear ✕</a>
    </div>
</form>

<div class="card bento-12">
    <?php if (empty($applications)): ?>
        <div class="empty-state"><div class="empty-icon">📝</div><p>No applications found.</p></div>
    <?php else: ?>
    <div class="table-wrapper">
        <table class="data-table">
            <thead><tr><th>Student</th><th>Internship</th><th>Company</th><th>Note</th><th>Status</th><th>Applied</th><?php if(isAdmin()): ?><th>Action</th><?php endif; ?></tr></thead>
            <tbody>
                <?php foreach ($applications as $a): ?>
                <tr>
                    <td style="font-weight:500"><?= htmlspecialchars($a['student_name']) ?></td>
                    <td><?= htmlspecialchars($a['internship_title']) ?></td>
                    <td><?= htmlspecialchars($a['company_name']) ?></td>
                    <td style="color:var(--text-muted);font-size:0.8rem;max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap"><?= htmlspecialchars($a['note_preview'] ?? '') ?></td>
                    <td><?php $cls = match($a['status']){'accepted'=>'success','pending'=>'warning','rejected'=>'danger','shortlisted'=>'primary',default=>'neutral'}; ?><span class="badge badge-<?= $cls ?>"><?= ucfirst($a['status']) ?></span></td>
                    <td style="color:var(--text-muted);font-size:0.8rem"><?= date('d M Y', strtotime($a['applied_at'])) ?></td>
                    <?php if(isAdmin()): ?>
                    <td>
                        <form method="POST" action="" style="display:flex;gap:4px;align-items:center">
                            <input type="hidden" name="application_id" value="<?= $a['application_id'] ?>">
                            <select name="status" class="select-field" style="width:130px;padding:6px 10px;font-size:0.78rem">
                                <?php foreach(['pending','shortlisted','accepted','rejected'] as $st): ?>
                                <option value="<?= $st ?>" <?= $a['status']===$st?'selected':'' ?>><?= ucfirst($st) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" name="update_status" class="btn btn-primary btn-sm" style="padding:6px 12px">Update</button>
                        </form>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
