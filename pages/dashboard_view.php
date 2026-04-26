<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Welcome back, <?= htmlspecialchars($_SESSION['username']) ?> · <?= date('l, d M Y') ?></p>
    </div>
</div>

<div class="bento-grid">

    <!-- STAT CARDS -->
    <?php
    $statDefs = [
        ['icon'=>'🎓','label'=>'Total Students',  'key'=>'total_students'],
        ['icon'=>'🏢','label'=>'Verified Companies','key'=>'total_companies'],
        ['icon'=>'📋','label'=>'Open Internships', 'key'=>'open_internships'],
        ['icon'=>'✅','label'=>'Placements',        'key'=>'total_placements'],
    ];
    foreach ($statDefs as $s): ?>
    <div class="card bento-3 stat-card">
        <span class="stat-icon"><?= $s['icon'] ?></span>
        <p class="stat-label"><?= $s['label'] ?></p>
        <h2 class="stat-number"><?= $stats[$s['key']] ?></h2>
    </div>
    <?php endforeach; ?>

    <!-- RECENT APPLICATIONS TABLE -->
    <div class="card bento-8">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:var(--s3)">
            <h3 style="font-size:1rem;font-weight:600">Recent Applications</h3>
            <a href="applications.php" class="btn btn-ghost btn-sm">View All</a>
        </div>
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Student</th><th>Internship</th><th>Company</th><th>Status</th><th>Applied</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentApps as $r): ?>
                    <tr>
                        <td><?= htmlspecialchars($r['student']) ?></td>
                        <td><?= htmlspecialchars($r['internship']) ?></td>
                        <td><?= htmlspecialchars($r['company_name']) ?></td>
                        <td>
                            <?php $cls = match($r['status']) {
                                'accepted'=>'success','pending'=>'warning',
                                'rejected'=>'danger','shortlisted'=>'primary', default=>'neutral'
                            }; ?>
                            <span class="badge badge-<?= $cls ?>"><?= ucfirst($r['status']) ?></span>
                        </td>
                        <td style="color:var(--text-muted);font-size:0.8rem"><?= date('d M Y', strtotime($r['applied_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- TOP COMPANIES -->
    <div class="card bento-4 bento-tall">
        <h3 style="font-size:1rem;font-weight:600;margin-bottom:var(--s3)">Top Companies</h3>
        <?php foreach ($topCompanies as $tc): ?>
        <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid rgba(0,0,0,0.05)">
            <span style="font-size:0.875rem;font-weight:500"><?= htmlspecialchars($tc['company_name']) ?></span>
            <span class="badge badge-primary"><?= $tc['app_count'] ?> apps</span>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- QUICK STATS ROW -->
    <div class="card bento-4 stat-card">
        <span class="stat-icon">⏳</span>
        <p class="stat-label">Pending Review</p>
        <h2 class="stat-number"><?= $stats['pending_apps'] ?></h2>
    </div>
    <div class="card bento-4 stat-card">
        <span class="stat-icon">💰</span>
        <p class="stat-label">Avg. Stipend (PKR)</p>
        <h2 class="stat-number"><?= number_format($stats['avg_stipend']) ?></h2>
    </div>

</div>
