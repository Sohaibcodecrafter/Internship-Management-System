<?php if (isset($_SESSION['flash'])): ?>
    <div class="alert alert-<?= $_SESSION['flash']['type'] ?>"><?= htmlspecialchars($_SESSION['flash']['msg']) ?></div>
    <?php unset($_SESSION['flash']); endif; ?>
<div class="page-header">
    <div>
        <h1 class="page-title">Companies</h1>
        <p class="page-subtitle">Manage partner companies</p>
    </div>
</div>

<!-- Search & Filter -->
<form method="GET" action="" id="filterForm">
    <div class="filter-bar">
        <div class="search-bar">
            <span class="search-icon">🔍</span>
            <input type="text" name="search" class="live-search"
                   value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                   placeholder="Search by name, industry, email...">
        </div>

        <select name="city" class="select-field" style="width:180px;" onchange="this.form.submit()">
            <option value="">All Cities</option>
            <?php foreach ($cities as $c): ?>
            <option value="<?= htmlspecialchars($c) ?>" <?= ($_GET['city'] ?? '') === $c ? 'selected' : '' ?>>
                <?= htmlspecialchars($c) ?>
            </option>
            <?php endforeach; ?>
        </select>

        <select name="verified" class="select-field" style="width:160px;" onchange="this.form.submit()">
            <option value="">All Status</option>
            <option value="1" <?= ($_GET['verified']??'')==='1' ?'selected':'' ?>>Verified</option>
            <option value="0" <?= ($_GET['verified']??'')==='0' ?'selected':'' ?>>Unverified</option>
        </select>

        <a href="?" class="btn btn-ghost btn-sm">Clear ✕</a>
    </div>
</form>

<!-- Companies Table -->
<div class="card bento-12">
    <?php if (empty($companies)): ?>
        <div class="empty-state">
            <div class="empty-icon">🏢</div>
            <p>No companies found matching your criteria.</p>
        </div>
    <?php else: ?>
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Company Name</th>
                    <th>Industry</th>
                    <th>City</th>
                    <th>Contact Email</th>
                    <th>Phone</th>
                    <th>Est. Year</th>
                    <th>Status</th>
                    <th>Account</th>
                    <?php if (isAdmin()): ?><th>Actions</th><?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($companies as $c): ?>
                <tr>
                    <td style="color:var(--text-muted)"><?= $c['company_id'] ?></td>
                    <td style="font-weight:500"><?= htmlspecialchars($c['company_name']) ?></td>
                    <td style="color:var(--text-secondary)"><?= htmlspecialchars($c['industry']) ?></td>
                    <td><?= htmlspecialchars($c['city']) ?></td>
                    <td style="color:var(--text-secondary);font-size:0.8rem"><?= htmlspecialchars($c['contact_email']) ?></td>
                    <td style="color:var(--text-muted)"><?= htmlspecialchars($c['contact_phone'] ?? '—') ?></td>
                    <td style="color:var(--text-muted)"><?= $c['established_year'] ?? '—' ?></td>
                    <td>
                        <?php if ($c['verified']): ?>
                            <span class="badge badge-success">Verified</span>
                        <?php else: ?>
                            <span class="badge badge-warning">Pending</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (isset($c['is_active'])): ?>
                            <span class="badge badge-<?= $c['is_active'] ? 'success' : 'danger' ?>"><?= $c['is_active'] ? 'Active' : 'Inactive' ?></span>
                        <?php endif; ?>
                    </td>
                    <?php if (isAdmin()): ?>
                    <td>
                        <form method="POST" style="display:inline">
                            <input type="hidden" name="user_id" value="<?= $c['user_id'] ?>">
                            <input type="hidden" name="new_active" value="<?= $c['is_active'] ? 0 : 1 ?>">
                            <button type="submit" name="toggle_active" class="btn btn-ghost btn-sm" style="color:var(--accent-<?= $c['is_active'] ? 'danger' : 'success' ?>)">
                                <?= $c['is_active'] ? 'Deactivate' : 'Activate' ?>
                            </button>
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
