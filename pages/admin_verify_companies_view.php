<?php if (isset($_SESSION['flash'])): ?>
    <div class="alert alert-<?= $_SESSION['flash']['type'] ?>"><?= htmlspecialchars($_SESSION['flash']['msg']) ?></div>
    <?php unset($_SESSION['flash']); endif; ?>

<div class="page-header"><div><h1 class="page-title">Verify Companies</h1><p class="page-subtitle"><?= count($pending) ?> pending</p></div></div>

<?php if (empty($pending)): ?>
    <div class="card" style="text-align:center;padding:var(--s5);color:var(--text-muted)">
        <div style="font-size:2rem;margin-bottom:var(--s2)">✅</div>
        <p style="font-size:1.1rem">All companies verified!</p>
        <p>No pending verification requests.</p>
    </div>
<?php else: ?>
<div class="card">
    <div class="table-wrapper">
        <table class="data-table">
            <thead><tr><th>Company</th><th>Industry</th><th>City</th><th>Contact Email</th><th>Registered</th><th>Account</th><th>Actions</th></tr></thead>
            <tbody>
            <?php foreach ($pending as $c): ?>
            <tr>
                <td data-label="Company">
                    <div style="font-weight:600"><?= htmlspecialchars($c['company_name']) ?></div>
                    <?php if (!empty($c['verification_requested'])): ?>
                        <span class="badge" style="background:var(--accent-warning);color:#fff;font-size:0.65rem;margin-top:4px">🔄 Re-verify Request</span>
                    <?php endif; ?>
                </td>
                <td data-label="Industry"><?= htmlspecialchars($c['industry']) ?></td>
                <td data-label="City"><?= htmlspecialchars($c['city']) ?></td>
                <td data-label="Contact Email" style="font-size:0.85rem"><?= htmlspecialchars($c['contact_email']) ?></td>
                <td data-label="Registered" style="font-size:0.8rem;color:var(--text-muted)"><?= date('d M Y', strtotime($c['reg_date'])) ?></td>
                <td data-label="Account"><span class="badge badge-<?= $c['is_active'] ? 'success' : 'danger' ?>"><?= $c['is_active'] ? 'Active' : 'Inactive' ?></span></td>
                <td data-label="Actions" style="display:flex;gap:4px">
                    <form method="POST" style="display:inline">
                        <input type="hidden" name="company_id" value="<?= $c['company_id'] ?>">
                        <button type="submit" name="approve" class="btn btn-primary btn-sm">✓ Approve</button>
                    </form>
                    <form method="POST" style="display:inline" onsubmit="return confirm('Reject this company verification?')">
                        <input type="hidden" name="company_id" value="<?= $c['company_id'] ?>">
                        <button type="submit" name="reject" class="btn btn-ghost btn-sm" style="color:var(--accent-danger)">✕ Reject</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>
