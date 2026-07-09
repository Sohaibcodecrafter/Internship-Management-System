<?php if (isset($_SESSION['flash'])): ?>
    <div class="alert alert-<?= $_SESSION['flash']['type'] ?>"><?= htmlspecialchars($_SESSION['flash']['msg']) ?></div>
    <?php unset($_SESSION['flash']); endif; ?>

<div class="page-header"><div><h1 class="page-title">My Applications</h1><p class="page-subtitle"><?= count($applications) ?> applications submitted</p></div></div>

<div class="card">
    <div class="table-wrapper">
        <table class="data-table">
            <thead><tr><th>Company</th><th>Internship</th><th>City</th><th>Stipend</th><th>Applied</th><th>Status</th><th>Action</th></tr></thead>
            <tbody>
            <?php foreach ($applications as $a):
                $statusColors = ['accepted'=>'success','pending'=>'warning','rejected'=>'danger','shortlisted'=>'primary'];
                $cls = $statusColors[$a['app_status']] ?? 'neutral';
            ?>
            <tr>
                <td data-label="Company"><?= htmlspecialchars($a['company_name']) ?></td>
                <td data-label="Internship"><?= htmlspecialchars($a['internship_title']) ?></td>
                <td data-label="City"><?= htmlspecialchars($a['company_city'] ?? '—') ?></td>
                <td data-label="Stipend"><?= $a['stipend'] > 0 ? 'PKR ' . number_format($a['stipend']) : '—' ?></td>
                <td data-label="Applied" style="font-size:0.8rem;color:var(--text-muted)"><?= date('d M Y', strtotime($a['applied_at'])) ?></td>
                <td data-label="Status"><span class="badge badge-<?= $cls ?>"><?= ucfirst($a['app_status']) ?></span></td>
                <td data-label="Action">
                    <?php if ($a['app_status'] === 'accepted' && !empty($a['placement_id'])): ?>
                        <a href="student_rate.php?company_id=<?= $a['company_id'] ?>" class="btn btn-primary btn-sm">⭐ Rate</a>
                    <?php elseif ($a['app_status'] === 'accepted'): ?>
                        <span class="badge badge-success">✓ Accepted</span>
                    <?php else: ?>
                        —
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($applications)): ?>
                <tr><td colspan="7" style="text-align:center;color:var(--text-muted);padding:var(--s4)">No applications yet. <a href="student_internships.php" style="color:var(--accent-primary)">Browse internships</a></td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
