<?php
ob_start();
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS — <?= htmlspecialchars($pageTitle ?? 'Dashboard') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/ims/assets/css/design-system.css">
    <link rel="stylesheet" href="/ims/assets/css/components.css">
    <link rel="stylesheet" href="/ims/assets/css/layout.css">
    <link rel="stylesheet" href="/ims/assets/css/sidebar-upgrade.css">
</head>
<body>
<div class="ims-layout" id="ims-layout">
<?php require_once __DIR__ . '/sidebar.php'; ?>
<div class="ims-overlay" id="ims-overlay"></div>
<div class="ims-main" id="ims-main">
    <!-- Topbar -->
    <header class="ims-topbar">
        <div style="display:flex;align-items:center">
            <button class="ims-topbar__mobile-toggle" id="ims-mobile-toggle" aria-label="Menu" onclick="IMSSidebar.mobileToggle()">
                <svg viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
            <div class="ims-topbar__left">
                <h1><?= htmlspecialchars($pageTitle ?? 'Dashboard') ?></h1>
            </div>
        </div>
        <div class="ims-topbar__actions">
            <button class="ims-topbar__btn" id="ims-theme-toggle" onclick="IMSTheme.toggle()" title="Toggle dark mode" aria-label="Toggle dark mode">
                <svg id="ims-icon-moon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                <svg id="ims-icon-sun" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
            </button>
            <div class="ims-topbar__avatar" title="<?= htmlspecialchars($_SESSION['username'] ?? 'User') ?>">
                <?= strtoupper(substr($_SESSION['username'] ?? 'U', 0, 1)) ?>
            </div>
        </div>
    </header>
    <div class="ims-main__content">
