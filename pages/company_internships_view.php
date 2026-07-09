<?php if (isset($_SESSION['flash'])): ?>
    <div class="alert alert-<?= $_SESSION['flash']['type'] ?>"><?= htmlspecialchars($_SESSION['flash']['msg']) ?></div>
    <?php unset($_SESSION['flash']); endif; ?>

<div class="page-header"><div><h1 class="page-title">My Internships</h1><p class="page-subtitle"><?= count($internships) ?> listings</p></div>
    <a href="company_post_internship.php" class="btn btn-primary">+ New Internship</a>
</div>

<div class="card">
    <div class="table-wrapper">
        <table class="data-table">
            <thead><tr><th>Title</th><th>Domain</th><th>Stipend</th><th>Duration</th><th>Start</th><th>Status</th><th>Applicants</th><th>Actions</th></tr></thead>
            <tbody>
            <?php foreach ($internships as $i): ?>
            <tr>
                <td data-label="Title" style="font-weight:500"><?= htmlspecialchars($i['title']) ?></td>
                <td data-label="Domain"><span class="badge badge-primary"><?= htmlspecialchars($i['domain']) ?></span></td>
                <td data-label="Stipend"><?= $i['stipend'] > 0 ? 'PKR ' . number_format($i['stipend']) : '—' ?></td>
                <td data-label="Duration"><?= $i['duration_months'] ?>m</td>
                <td data-label="Start" style="font-size:0.8rem"><?= date('d M Y', strtotime($i['start_date'])) ?></td>
                <td data-label="Status"><span class="badge badge-<?= $i['status'] === 'open' ? 'success' : 'neutral' ?>"><?= ucfirst($i['status']) ?></span></td>
                <td data-label="Applicants"><a href="company_applicants.php?internship_id=<?= $i['internship_id'] ?>" style="color:var(--accent-primary);font-weight:600"><?= $i['app_count'] ?></a></td>
                <td data-label="Actions" style="display:flex;gap:4px;align-items:center">
                    <form method="POST" style="display:inline">
                        <input type="hidden" name="internship_id" value="<?= $i['internship_id'] ?>">
                        <input type="hidden" name="current_status" value="<?= $i['status'] ?>">
                        <button type="submit" name="toggle_status" class="btn btn-sm <?= $i['status'] === 'open' ? 'btn-ghost' : 'btn-primary' ?>">
                            <?php if ($i['status'] === 'open'): ?>
                                <?= icon('lock', 15) ?> Close
                            <?php else: ?>
                                <?= icon('unlock', 15) ?> Reopen
                            <?php endif; ?>
                        </button>
                    </form>
                    <?php if ($i['app_count'] == 0): ?>
                    <form method="POST" style="display:inline" onsubmit="return confirmDelete()">
                        <input type="hidden" name="internship_id" value="<?= $i['internship_id'] ?>">
                        <button type="submit" name="delete" class="btn btn-ghost btn-sm" style="color:var(--accent-danger)">Delete</button>
                    </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($internships)): ?><tr><td colspan="8" style="text-align:center;color:var(--text-muted);padding:var(--s4)">No internships posted yet.</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
