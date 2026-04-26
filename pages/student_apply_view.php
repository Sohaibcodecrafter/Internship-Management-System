<?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="page-header"><div><h1 class="page-title">Apply: <?= htmlspecialchars($intern['title']) ?></h1><p class="page-subtitle"><?= htmlspecialchars($intern['company_name']) ?> · <?= htmlspecialchars($intern['company_city']) ?></p></div></div>

<div class="bento-grid">
    <div class="card bento-8">
        <h3 style="font-size:1rem;font-weight:600;margin-bottom:var(--s2)">Internship Details</h3>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--s2);font-size:0.85rem;color:var(--text-secondary);margin-bottom:var(--s3)">
            <div><strong>Domain:</strong> <?= htmlspecialchars($intern['domain']) ?></div>
            <div><strong>Duration:</strong> <?= $intern['duration_months'] ?> months</div>
            <div><strong>Stipend:</strong> <?= $intern['stipend'] > 0 ? 'PKR ' . number_format($intern['stipend']) . '/month' : 'Unpaid' ?></div>
            <div><strong>Slots:</strong> <?= $intern['slots'] ?></div>
            <div><strong>Start:</strong> <?= date('d M Y', strtotime($intern['start_date'])) ?></div>
            <div><strong>End:</strong> <?= date('d M Y', strtotime($intern['end_date'])) ?></div>
        </div>
        <?php if ($intern['description']): ?>
            <p style="font-size:0.85rem;color:var(--text-secondary);line-height:1.6"><?= nl2br(htmlspecialchars($intern['description'])) ?></p>
        <?php endif; ?>
    </div>
    <div class="card bento-4">
        <h3 style="font-size:1rem;font-weight:600;margin-bottom:var(--s2)">Your Application</h3>
        <form method="POST">
            <div class="input-group">
                <label class="input-label" for="cover_note">Cover Letter (min 100 chars)</label>
                <textarea id="cover_note" name="cover_note" class="input-field" rows="8" required placeholder="Tell the company why you're a great fit..."><?= htmlspecialchars($_POST['cover_note'] ?? '') ?></textarea>
                <span style="font-size:0.72rem;color:var(--text-muted)" id="char-count">0 / 100 min</span>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:var(--s2)">Submit Application →</button>
        </form>
        <script>
        document.getElementById('cover_note').addEventListener('input', function() {
            document.getElementById('char-count').textContent = this.value.length + ' / 100 min';
        });
        </script>
    </div>
</div>
