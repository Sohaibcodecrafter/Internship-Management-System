<div class="page-header">
    <div>
        <h1 class="page-title">Internships</h1>
        <p class="page-subtitle">Browse all internship opportunities</p>
    </div>
</div>

<form method="GET" action="" id="filterForm">
    <div class="filter-bar">
        <div class="search-bar">
            <span class="search-icon">🔍</span>
            <input type="text" name="search" class="live-search"
                   value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                   placeholder="Search by title, domain, company...">
        </div>
        <select name="domain" class="select-field" style="width:180px;" onchange="this.form.submit()">
            <option value="">All Domains</option>
            <?php foreach ($domains as $dom): ?>
            <option value="<?= htmlspecialchars($dom) ?>" <?= ($_GET['domain']??'')===$dom?'selected':'' ?>><?= htmlspecialchars($dom) ?></option>
            <?php endforeach; ?>
        </select>
        <select name="internship_status" class="select-field" style="width:160px;" onchange="this.form.submit()">
            <option value="">All Statuses</option>
            <option value="open" <?= ($_GET['internship_status']??'')==='open'?'selected':'' ?>>Open</option>
            <option value="closed" <?= ($_GET['internship_status']??'')==='closed'?'selected':'' ?>>Closed</option>
            <option value="completed" <?= ($_GET['internship_status']??'')==='completed'?'selected':'' ?>>Completed</option>
        </select>
        <input type="number" name="stipend_min" class="input-field" style="width:110px" placeholder="Min PKR" value="<?= htmlspecialchars($_GET['stipend_min'] ?? '') ?>">
        <input type="number" name="stipend_max" class="input-field" style="width:110px" placeholder="Max PKR" value="<?= htmlspecialchars($_GET['stipend_max'] ?? '') ?>">
        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        <a href="?" class="btn btn-ghost btn-sm">Clear ✕</a>
    </div>
</form>

<div class="card bento-12">
    <?php if (empty($internships)): ?>
        <div class="empty-state"><div class="empty-icon">📋</div><p>No internships found.</p></div>
    <?php else: ?>
    <div class="table-wrapper">
        <table class="data-table">
            <thead><tr><th>Title</th><th>Company</th><th>Domain</th><th>Supervisor</th><th>Stipend</th><th>Duration</th><th>Slots</th><th>Status</th></tr></thead>
            <tbody>
                <?php foreach ($internships as $i): ?>
                <tr>
                    <td style="font-weight:500"><?= htmlspecialchars($i['title']) ?></td>
                    <td><?= htmlspecialchars($i['company_name']) ?></td>
                    <td><span class="badge badge-primary"><?= htmlspecialchars($i['domain']) ?></span></td>
                    <td style="color:var(--text-secondary)"><?= htmlspecialchars($i['supervisor_name'] ?? '—') ?></td>
                    <td style="font-weight:600">PKR <?= number_format($i['stipend']) ?></td>
                    <td style="color:var(--text-muted)"><?= $i['duration_months'] ?> mo</td>
                    <td><?= $i['slots'] ?></td>
                    <td><?php $cls = match($i['status']){'open'=>'success','closed'=>'danger','completed'=>'primary',default=>'neutral'}; ?><span class="badge badge-<?= $cls ?>"><?= ucfirst($i['status']) ?></span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
