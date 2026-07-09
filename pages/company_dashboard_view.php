<div class="page-header"><div><h1 class="page-title">Welcome, <?= htmlspecialchars($company['company_name']) ?></h1><p class="page-subtitle">Company Dashboard Overview</p></div>
    <div style="display:flex;gap:var(--s2)">
        <a href="company_post_internship.php" class="btn btn-primary">+ Post Internship</a>
        <a href="company_applicants.php" class="btn btn-ghost">View Applicants</a>
    </div>
</div>

<div class="ims-stats-grid">
    <div class="ims-stat-card">
        <div class="ims-stat-card__top"><div class="ims-stat-card__icon" data-color="primary"><?= icon('briefcase', 20) ?></div></div>
        <div class="ims-stat-card__label">Total Internships</div>
        <div class="ims-stat-card__value"><?= $data['total_internships'] ?></div>
    </div>
    <div class="ims-stat-card">
        <div class="ims-stat-card__top"><div class="ims-stat-card__icon" data-color="success"><?= icon('file-text', 20) ?></div></div>
        <div class="ims-stat-card__label">Applications Received</div>
        <div class="ims-stat-card__value"><?= $data['total_applications'] ?></div>
    </div>
    <div class="ims-stat-card">
        <div class="ims-stat-card__top"><div class="ims-stat-card__icon" data-color="warning"><?= icon('activity', 20) ?></div></div>
        <div class="ims-stat-card__label">Open Positions</div>
        <div class="ims-stat-card__value"><?= $data['open_internships'] ?></div>
    </div>
    <div class="ims-stat-card">
        <div class="ims-stat-card__top"><div class="ims-stat-card__icon" data-color="accent"><?= icon('check-circle', 20) ?></div></div>
        <div class="ims-stat-card__label">Accepted Placements</div>
        <div class="ims-stat-card__value"><?= $data['accepted_placements'] ?></div>
        <div class="ims-stat-card__sub"><?= $data['accepted_count'] ?> accepted · <?= $data['accepted_placements'] ?> placed</div>
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
                    <td data-label="Student"><?= htmlspecialchars($r['full_name']) ?></td>
                    <td data-label="Internship"><?= htmlspecialchars($r['title']) ?></td>
                    <td data-label="Date" style="font-size:0.8rem;color:var(--text-muted)"><?= date('d M Y', strtotime($r['applied_at'])) ?></td>
                    <td data-label="Status"><span class="badge badge-<?= $cls ?>"><?= ucfirst($r['status']) ?></span></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($recentApps)): ?><tr><td colspan="4" style="text-align:center;color:var(--text-muted)">No applications yet</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Step 11: Pie Chart -->
    <div class="ims-panel" style="display:flex;flex-direction:column;gap:1rem;">
        <div class="ims-panel__header"><h3 class="ims-panel__title">Application Breakdown</h3></div>
        <canvas id="ims-pie-chart" width="220" height="220" style="max-width:220px;margin:0 auto;display:block;"></canvas>
        <div id="ims-pie-legend" style="display:flex;flex-wrap:wrap;gap:0.5rem;justify-content:center;margin-top:0.5rem;"></div>
    </div>
</div>

<script>
(function() {
    var raw   = <?= $data['pie_json'] ?>;
    var total = Object.values(raw).reduce(function(a,b){return a+b;},0);
    if (total === 0) return;
    var colors = { pending:'#f59e0b', shortlisted:'#f97316', accepted:'#22c55e', rejected:'#ef4444' };
    var canvas = document.getElementById('ims-pie-chart');
    var legend = document.getElementById('ims-pie-legend');
    if (!canvas) return;
    var ctx = canvas.getContext('2d');
    var cx = canvas.width/2, cy = canvas.height/2, r = Math.min(cx,cy)-10;
    var startAngle = -Math.PI/2;
    var cs = getComputedStyle(document.documentElement);
    var surfaceColor = cs.getPropertyValue('--ims-surface').trim() || '#fff';
    var textColor = cs.getPropertyValue('--ims-text').trim() || '#111';
    var mutedColor = cs.getPropertyValue('--ims-text-muted').trim() || '#6b7280';

    Object.entries(raw).forEach(function(entry) {
        var status = entry[0], count = entry[1];
        if (count === 0) return;
        var slice = (count/total) * 2 * Math.PI;
        ctx.beginPath(); ctx.moveTo(cx,cy);
        ctx.arc(cx,cy,r,startAngle,startAngle+slice);
        ctx.closePath(); ctx.fillStyle = colors[status]||'#94a3b8'; ctx.fill();
        startAngle += slice;
        var pct = Math.round((count/total)*100);
        var item = document.createElement('div');
        item.style.cssText = 'display:flex;align-items:center;gap:0.35rem;font-size:0.72rem;';
        item.innerHTML = '<span style="width:10px;height:10px;border-radius:50%;background:'+colors[status]+';flex-shrink:0"></span><span style="color:'+mutedColor+';text-transform:capitalize">'+status+' ('+pct+'%)</span>';
        legend.appendChild(item);
    });
    // Donut hole
    ctx.beginPath(); ctx.arc(cx,cy,r*0.55,0,2*Math.PI);
    ctx.fillStyle = surfaceColor; ctx.fill();
    // Center label
    ctx.fillStyle = textColor; ctx.font = 'bold 1rem Inter, sans-serif';
    ctx.textAlign = 'center'; ctx.textBaseline = 'middle';
    ctx.fillText(total, cx, cy-8);
    ctx.font = '0.65rem Inter, sans-serif'; ctx.fillStyle = mutedColor;
    ctx.fillText('total', cx, cy+10);
})();
</script>
