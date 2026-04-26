<div class="page-header"><div><h1 class="page-title">Notifications</h1><p class="page-subtitle"><?= count($notifications) ?> total notifications</p></div></div>
<div class="card">
    <?php if (empty($notifications)): ?>
        <p style="text-align:center;padding:var(--s4);color:var(--text-muted)">No notifications yet.</p>
    <?php else: ?>
        <?php foreach ($notifications as $n):
            $ago = (new DateTime($n['created_at']))->diff(new DateTime());
            if ($ago->days > 0) $timeAgo = $ago->days . 'd ago';
            elseif ($ago->h > 0) $timeAgo = $ago->h . 'h ago';
            elseif ($ago->i > 0) $timeAgo = $ago->i . 'm ago';
            else $timeAgo = 'Just now';
        ?>
        <div class="ims-activity__item" style="<?= $n['is_read'] ? '' : 'background:rgba(61,90,254,0.04);border-left:3px solid var(--accent-primary);' ?>">
            <div class="ims-activity__icon" data-color="primary">🔔</div>
            <div class="ims-activity__body">
                <div class="ims-activity__title"><?= htmlspecialchars($n['message']) ?></div>
            </div>
            <div class="ims-activity__time"><?= $timeAgo ?></div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
