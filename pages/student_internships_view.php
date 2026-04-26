<div class="page-header"><div><h1 class="page-title">Browse Internships</h1><p class="page-subtitle"><?= $total ?> open positions available</p></div></div>

<!-- Filters -->
<div class="card" style="margin-bottom:var(--s4);padding:var(--s3)">
    <form method="GET" style="display:flex;gap:var(--s2);flex-wrap:wrap;align-items:flex-end">
        <div class="input-group" style="flex:1;min-width:150px;margin-bottom:0">
            <label class="input-label">City</label>
            <select name="city" class="select-field">
                <option value="">All Cities</option>
                <?php foreach ($cities as $c): ?>
                    <option value="<?= $c ?>" <?= ($_GET['city'] ?? '') === $c ? 'selected' : '' ?>><?= $c ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="input-group" style="flex:1;min-width:150px;margin-bottom:0">
            <label class="input-label">Domain</label>
            <input type="text" name="domain" class="input-field" placeholder="e.g. Web Dev" value="<?= htmlspecialchars($_GET['domain'] ?? '') ?>">
        </div>
        <div class="input-group" style="flex:1;min-width:120px;margin-bottom:0">
            <label class="input-label">Min Stipend (PKR)</label>
            <input type="number" name="stipend_min" class="input-field" placeholder="0" value="<?= htmlspecialchars($_GET['stipend_min'] ?? '') ?>">
        </div>
        <label style="display:flex;align-items:center;gap:6px;font-size:0.85rem;cursor:pointer;padding:10px 0">
            <input type="checkbox" name="is_paid" value="1" <?= !empty($_GET['is_paid']) ? 'checked' : '' ?>> Paid Only
        </label>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>
</div>

<!-- Internship Cards Grid -->
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:var(--s3)">
    <?php foreach ($internships as $i): ?>
    <div class="card" style="display:flex;flex-direction:column;gap:var(--s2);padding:var(--s3)">
        <div style="display:flex;justify-content:space-between;align-items:flex-start">
            <div>
                <h3 style="font-size:1rem;font-weight:600;margin-bottom:2px"><?= htmlspecialchars($i['title']) ?></h3>
                <p style="font-size:0.82rem;color:var(--text-muted)"><?= htmlspecialchars($i['company_name']) ?></p>
            </div>
            <?php if ($i['stipend'] > 0): ?>
                <span class="badge badge-success">Paid</span>
            <?php else: ?>
                <span class="badge badge-neutral">Unpaid</span>
            <?php endif; ?>
        </div>
        <div style="display:flex;gap:var(--s3);font-size:0.8rem;color:var(--text-secondary)">
            <span>📍 <?= htmlspecialchars($i['company_city']) ?></span>
            <span>⏱ <?= $i['duration_months'] ?> months</span>
        </div>
        <?php if ($i['stipend'] > 0): ?>
            <div style="font-weight:700;color:var(--accent-success)">PKR <?= number_format($i['stipend']) ?>/month</div>
        <?php endif; ?>
        <p style="font-size:0.8rem;color:var(--text-muted)"><?= htmlspecialchars($i['domain']) ?></p>
        <div style="margin-top:auto;display:flex;justify-content:space-between;align-items:center;padding-top:var(--s2);border-top:1px solid rgba(0,0,0,0.06)">
            <span style="font-size:0.75rem;color:var(--text-muted)">Start: <?= date('d M Y', strtotime($i['start_date'])) ?></span>
            <?php if (in_array($i['internship_id'], $appliedIds)): ?>
                <span class="badge badge-primary" style="cursor:default">✓ Applied</span>
            <?php else: ?>
                <a href="student_apply.php?internship_id=<?= $i['internship_id'] ?>" class="btn btn-primary btn-sm">Apply →</a>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
    <?php if (empty($internships)): ?>
        <div class="card" style="grid-column:1/-1;text-align:center;padding:var(--s5);color:var(--text-muted)">
            No internships match your filters. Try broadening your search.
        </div>
    <?php endif; ?>
</div>

<!-- Pagination -->
<?php if ($totalPages > 1): ?>
<div style="display:flex;justify-content:center;gap:var(--s1);margin-top:var(--s4)">
    <?php for ($p = 1; $p <= $totalPages; $p++): ?>
        <a href="?<?= http_build_query(array_merge($_GET, ['page' => $p])) ?>"
           class="btn <?= $p === $page ? 'btn-primary' : 'btn-ghost' ?> btn-sm"><?= $p ?></a>
    <?php endfor; ?>
</div>
<?php endif; ?>
