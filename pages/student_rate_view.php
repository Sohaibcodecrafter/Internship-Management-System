<?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<div class="page-header"><div><h1 class="page-title">Rate <?= htmlspecialchars($company['company_name']) ?></h1><p class="page-subtitle"><?= htmlspecialchars($company['industry']) ?> · <?= htmlspecialchars($company['city']) ?></p></div></div>
<div class="card" style="max-width:500px">
    <form method="POST">
        <div class="input-group">
            <label class="input-label">Rating</label>
            <div id="star-rating" style="display:flex;gap:4px;font-size:2rem;cursor:pointer">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <span data-val="<?= $i ?>" style="color:var(--text-muted);transition:color 0.15s" onmouseenter="highlightStars(<?= $i ?>)" onclick="setRating(<?= $i ?>)">★</span>
                <?php endfor; ?>
            </div>
            <input type="hidden" name="rating" id="rating-val" value="0" required>
        </div>
        <div class="input-group">
            <label class="input-label" for="comment">Comment (optional)</label>
            <textarea id="comment" name="comment" class="input-field" rows="4" placeholder="Share your experience..."><?= htmlspecialchars($_POST['comment'] ?? '') ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:var(--s2)">Submit Review →</button>
    </form>
</div>
<script>
var selectedRating = 0;
function highlightStars(n) {
    document.querySelectorAll('#star-rating span').forEach(function(s,i) {
        s.style.color = (i < n) ? 'var(--accent-warning)' : 'var(--text-muted)';
    });
}
function setRating(n) {
    selectedRating = n;
    document.getElementById('rating-val').value = n;
    highlightStars(n);
}
document.getElementById('star-rating').addEventListener('mouseleave', function() {
    highlightStars(selectedRating);
});
</script>
