<!-- ═══ STATS GRID ═══ -->
<div class="ims-stats-grid">

    <div class="ims-stat-card">
        <div class="ims-stat-card__top">
            <div class="ims-stat-card__icon" data-color="primary">
                <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
            </div>
            <span class="ims-stat-card__trend">↑ Active</span>
        </div>
        <div class="ims-stat-card__label">Open Internships</div>
        <div class="ims-stat-card__value"><?= $stats['open_internships'] ?></div>
        <div class="ims-stat-card__sub">Currently accepting applications</div>
    </div>

    <div class="ims-stat-card">
        <div class="ims-stat-card__top">
            <div class="ims-stat-card__icon" data-color="success">
                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <span class="ims-stat-card__trend">↑ Growing</span>
        </div>
        <div class="ims-stat-card__label">Students Registered</div>
        <div class="ims-stat-card__value"><?= $stats['total_students'] ?></div>
        <div class="ims-stat-card__sub">Active student accounts</div>
    </div>

    <div class="ims-stat-card">
        <div class="ims-stat-card__top">
            <div class="ims-stat-card__icon" data-color="warning">
                <svg viewBox="0 0 24 24"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/></svg>
            </div>
            <span class="ims-stat-card__trend">✓ Verified</span>
        </div>
        <div class="ims-stat-card__label">Verified Companies</div>
        <div class="ims-stat-card__value"><?= $stats['total_companies'] ?></div>
        <div class="ims-stat-card__sub">Approved & active</div>
    </div>

    <div class="ims-stat-card">
        <div class="ims-stat-card__top">
            <div class="ims-stat-card__icon" data-color="accent">
                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            </div>
            <span class="ims-stat-card__trend">↑ This month</span>
        </div>
        <div class="ims-stat-card__label">Applications</div>
        <div class="ims-stat-card__value"><?= $stats['total_applications'] ?></div>
        <div class="ims-stat-card__sub">Total submitted</div>
    </div>

</div>

<!-- ═══ CONTENT GRID ═══ -->
<div class="ims-content-grid">

    <!-- LEFT: Recent Applications -->
    <div class="ims-panel">
        <div class="ims-panel__header">
            <h3 class="ims-panel__title">Recent Applications</h3>
            <a href="applications.php" class="ims-panel__link">View all →</a>
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

    <!-- RIGHT: Stats + Activity -->
    <div style="display:flex; flex-direction:column; gap:1.25rem;">

        <!-- Platform Stats (Progress Bars) -->
        <div class="ims-panel">
            <div class="ims-panel__header">
                <h3 class="ims-panel__title">Platform Stats</h3>
            </div>
            <div class="ims-progress">
                <div class="ims-progress__header">
                    <span class="ims-progress__label">Placement Rate</span>
                    <span class="ims-progress__value"><?= $stats['placement_rate'] ?>%</span>
                </div>
                <div class="ims-progress__track">
                    <div class="ims-progress__fill" style="width:<?= $stats['placement_rate'] ?>%; background:var(--accent-primary)"></div>
                </div>
            </div>
            <div class="ims-progress">
                <div class="ims-progress__header">
                    <span class="ims-progress__label">Verified Companies</span>
                    <span class="ims-progress__value"><?= $stats['verified_pct'] ?>%</span>
                </div>
                <div class="ims-progress__track">
                    <div class="ims-progress__fill" style="width:<?= $stats['verified_pct'] ?>%; background:var(--accent-success)"></div>
                </div>
            </div>
            <div class="ims-progress">
                <div class="ims-progress__header">
                    <span class="ims-progress__label">Open Internships</span>
                    <span class="ims-progress__value"><?= $stats['open_pct'] ?>%</span>
                </div>
                <div class="ims-progress__track">
                    <div class="ims-progress__fill" style="width:<?= $stats['open_pct'] ?>%; background:var(--accent-warning)"></div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="ims-panel">
            <div class="ims-panel__header">
                <h3 class="ims-panel__title">Recent Activity</h3>
            </div>
            <?php foreach ($recentActivity as $act):
                $actColor = match($act['status']) {
                    'accepted'=>'success', 'pending'=>'warning', default=>'primary'
                };
                $actIcon = match($act['status']) {
                    'accepted'=>'✅', 'rejected'=>'❌', 'shortlisted'=>'⭐', default=>'📋'
                };
                $timeAgo = date('d M', strtotime($act['applied_at']));
            ?>
            <div class="ims-activity__item">
                <div class="ims-activity__icon" data-color="<?= $actColor ?>"><?= $actIcon ?></div>
                <div class="ims-activity__body">
                    <div class="ims-activity__title"><?= htmlspecialchars($act['student']) ?></div>
                    <div class="ims-activity__desc">Applied to <?= htmlspecialchars($act['internship']) ?></div>
                </div>
                <div class="ims-activity__time"><?= $timeAgo ?></div>
            </div>
            <?php endforeach; ?>
            <?php if (empty($recentActivity)): ?>
                <p style="text-align:center;color:var(--text-muted);font-size:0.85rem;padding:1rem 0;">No recent activity</p>
            <?php endif; ?>
        </div>

        <!-- Top Companies -->
        <div class="ims-panel">
            <div class="ims-panel__header">
                <h3 class="ims-panel__title">Top Companies</h3>
                <a href="companies.php" class="ims-panel__link">View all →</a>
            </div>
            <?php foreach ($topCompanies as $tc): ?>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid rgba(0,0,0,0.05)">
                <span style="font-size:0.875rem;font-weight:500"><?= htmlspecialchars($tc['company_name']) ?></span>
                <span class="badge badge-primary"><?= $tc['app_count'] ?> apps</span>
            </div>
            <?php endforeach; ?>
        </div>

    </div><!-- /right column -->

</div><!-- /ims-content-grid -->
