<?php ob_start();
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
$role = $_SESSION['role'] ?? '';

// Icons as inline SVGs
$icons = [
    'dashboard'    => '<svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>',
    'students'     => '<svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
    'companies'    => '<svg viewBox="0 0 24 24"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/></svg>',
    'internships'  => '<svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>',
    'applications' => '<svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>',
    'reports'      => '<svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>',
    'profile'      => '<svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
    'browse'       => '<svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>',
    'post'         => '<svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>',
    'applicants'   => '<svg viewBox="0 0 24 24"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1"/></svg>',
    'verify'       => '<svg viewBox="0 0 24 24"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="10"/></svg>',
    'bell'         => '<svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>',
    'star'         => '<svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>',
    'logout'       => '<svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>',
];

// Build nav sections based on role
$navSections = [];

if ($role === 'admin') {
    $navSections['main'] = [
        'label' => 'Main',
        'items' => [
            ['page' => 'dashboard',              'label' => 'Dashboard',         'icon' => $icons['dashboard']],
            ['page' => 'students',               'label' => 'Students',          'icon' => $icons['students']],
            ['page' => 'companies',              'label' => 'Companies',         'icon' => $icons['companies']],
        ],
    ];
    $navSections['manage'] = [
        'label' => 'Management',
        'items' => [
            ['page' => 'internships',            'label' => 'Internships',       'icon' => $icons['internships']],
            ['page' => 'applications',           'label' => 'Applications',      'icon' => $icons['applications']],
            ['page' => 'reports',                'label' => 'Reports',           'icon' => $icons['reports']],
            ['page' => 'admin_verify_companies', 'label' => 'Verify Companies',  'icon' => $icons['verify']],
        ],
    ];
} elseif ($role === 'student') {
    $navSections['student'] = [
        'label' => 'Student Portal',
        'items' => [
            ['page' => 'student_profile',       'label' => 'My Profile',         'icon' => $icons['profile']],
            ['page' => 'student_internships',   'label' => 'Browse Internships', 'icon' => $icons['browse']],
            ['page' => 'student_applications',  'label' => 'My Applications',    'icon' => $icons['applications']],
        ],
    ];
} elseif ($role === 'company') {
    $navSections['company'] = [
        'label' => 'Company Portal',
        'items' => [
            ['page' => 'company_dashboard',       'label' => 'Dashboard',          'icon' => $icons['dashboard']],
            ['page' => 'company_post_internship', 'label' => 'Post Internship',    'icon' => $icons['post']],
            ['page' => 'company_internships',     'label' => 'My Internships',     'icon' => $icons['internships']],
            ['page' => 'company_applicants',      'label' => 'Applicants',         'icon' => $icons['applicants']],
        ],
    ];
}

// Notification count (all roles)
$notifCount = 0;
try {
    $pdo = getDB();
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM notifications WHERE user_id = ? AND is_read = 0');
    $stmt->execute([currentUserId()]);
    $notifCount = (int)$stmt->fetchColumn();
} catch (Exception $e) {}

?>
<aside class="ims-sidebar" id="ims-sidebar">
    <!-- Brand -->
    <div class="ims-sidebar__brand">
        <div class="ims-brand__logo">
            <svg viewBox="0 0 24 24" width="22" height="22" stroke="#fff" fill="none" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 10 3 12 0v-5"/></svg>
        </div>
        <div class="ims-brand__info">
            <span class="ims-brand__name">IMS Portal</span>
            <span class="ims-brand__plan"><?= htmlspecialchars(ucfirst($role)) ?> Account</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="ims-nav">
        <?php foreach ($navSections as $section): ?>
        <div class="ims-sidebar__section">
            <div class="ims-sidebar__section-label"><?= $section['label'] ?></div>
            <?php foreach ($section['items'] as $item): ?>
            <a href="/ims/pages/<?= $item['page'] ?>.php"
               class="ims-nav__item <?= $currentPage === $item['page'] ? 'ims-nav__item--active' : '' ?>"
               data-tooltip="<?= $item['label'] ?>">
                <span class="ims-nav__icon"><?= $item['icon'] ?></span>
                <span class="ims-nav__label"><?= $item['label'] ?></span>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endforeach; ?>

        <!-- Notifications (all roles) -->
        <div class="ims-sidebar__section">
            <div class="ims-sidebar__section-label">Notifications</div>
            <a href="/ims/pages/notifications.php"
               class="ims-nav__item <?= $currentPage === 'notifications' ? 'ims-nav__item--active' : '' ?>"
               data-tooltip="Notifications">
                <span class="ims-nav__icon"><?= $icons['bell'] ?></span>
                <span class="ims-nav__label">Notifications</span>
                <?php if ($notifCount > 0): ?>
                    <span class="ims-nav__badge"><?= $notifCount ?></span>
                <?php endif; ?>
            </a>
        </div>
    </nav>

    <!-- Toggle + Logout -->
    <div class="ims-sidebar__toggle">
        <a href="/ims/auth/logout.php" class="ims-nav__item" data-tooltip="Logout" style="color:var(--accent-danger)">
            <span class="ims-nav__icon"><?= $icons['logout'] ?></span>
            <span class="ims-nav__label">Logout</span>
        </a>
        <button class="ims-toggle__btn" id="ims-sidebar-toggle" aria-label="Toggle sidebar" onclick="IMSSidebar.toggle()">
            <span class="ims-toggle__icon">
                <svg viewBox="0 0 24 24"><polyline points="11 17 6 12 11 7"/><polyline points="18 17 13 12 18 7"/></svg>
            </span>
            <span class="ims-toggle__label">Collapse</span>
        </button>
    </div>
</aside>
