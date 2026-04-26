<?php
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
$navItems = [
    'dashboard'    => ['label' => 'Dashboard',    'icon' => '📊'],
    'students'     => ['label' => 'Students',      'icon' => '🎓'],
    'companies'    => ['label' => 'Companies',     'icon' => '🏢'],
    'internships'  => ['label' => 'Internships',   'icon' => '📋'],
    'applications' => ['label' => 'Applications',  'icon' => '📝'],
    'reports'      => ['label' => 'Reports',       'icon' => '📈'],
];
?>
<aside class="sidebar">
    <div class="sidebar-brand">
        <span class="brand-icon">🏛</span>
        <span class="brand-text">IMS</span>
    </div>
    <nav class="sidebar-nav">
        <?php foreach ($navItems as $page => $item): ?>
            <a href="/ims/pages/<?= $page ?>.php"
               class="nav-item <?= $currentPage === $page ? 'active' : '' ?>">
                <span class="nav-icon"><?= $item['icon'] ?></span>
                <span class="nav-label"><?= $item['label'] ?></span>
            </a>
        <?php endforeach; ?>
    </nav>
    <div class="sidebar-footer">
        <span class="user-badge"><?= htmlspecialchars($_SESSION['username'] ?? '') ?></span>
        <a href="/ims/auth/logout.php" class="logout-link">Logout</a>
    </div>
</aside>
