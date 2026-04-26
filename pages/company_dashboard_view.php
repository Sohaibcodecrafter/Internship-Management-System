<div class="page-header"><div><h1 class="page-title">Welcome, <?= htmlspecialchars($company['company_name']) ?></h1><p class="page-subtitle">Company Dashboard Overview</p></div>
    <div style="display:flex;gap:var(--s2)">
        <a href="company_post_internship.php" class="btn btn-primary">+ Post Internship</a>
        <a href="company_applicants.php" class="btn btn-ghost">View Applicants</a>
    </div>
</div>

<div class="ims-stats-grid">
    <div class="ims-stat-card">
        <div class="ims-stat-card__top"><div class="ims-stat-card__icon" data-color="primary"><svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></div></div>
        <div class="ims-stat-card__label">Total Internships</div>
        <div class="ims-stat-card__value"><?= $stats['total_internships'] ?></div>
    </div>
    <div class="ims-stat-card">
        <div class="ims-stat-card__top"><div class="ims-stat-card__icon" data-color="success"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div></div>
        <div class="ims-stat-card__label">Applications Received</div>
        <div class="ims-stat-card__value"><?= $stats['total_applications'] ?></div>
    </div>
    <div class="ims-stat-card">
        <div class="ims-stat-card__top"><div class="ims-stat-card__icon" data-color="warning"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div></div>
        <div class="ims-stat-card__label">Open Positions</div>
        <div class="ims-stat-card__value"><?= $stats['open_internships'] ?></div>
    </div>
    <div class="ims-stat-card">
        <div class="ims-stat-card__top"><div class="ims-stat-card__icon" data-color="accent"><svg viewBox="0 0 24 24"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="10"/></svg></div></div>
        <div class="ims-stat-card__label">Accepted Placements</div>
        <div class="ims-stat-card__value"><?= $stats['accepted_placements'] ?></div>
    </div>
</div>

<div class="ims-content-grid">
    <div class="ims-panel">
        <div class="ims-panel__header"><h3 class="ims-panel__title">Recent Applications</h3><a href="company_applicants.php" class="ims-panel__link">View all →</a></div>
        <div class="table-wrapper">
            <table class="data-table">
                <thead><tr><th>Student</th><th>Internship</th><th>Date</th><th>Status</th></tr></thead>
                <tbody>
                <?php foreach ($recentApps as $r):
                    $cls = match($r['status']) { 'accepted'=>'success','pending'=>'warning','rejected'=>'danger','shortlisted'=>'primary', default=>'neutral' };
                ?>
                <tr>
                    <td><?= htmlspecialchars($r['full_name']) ?></td>
                    <td><?= htmlspecialchars($r['title']) ?></td>
                    <td style="font-size:0.8rem;color:var(--text-muted)"><?= date('d M Y', strtotime($r['applied_at'])) ?></td>
                    <td><span class="badge badge-<?= $cls ?>"><?= ucfirst($r['status']) ?></span></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($recentApps)): ?><tr><td colspan="4" style="text-align:center;color:var(--text-muted)">No applications yet</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div></div>
</div>
