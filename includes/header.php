<?php
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
</head>
<body>
<div class="app-wrapper">
<?php require_once __DIR__ . '/sidebar.php'; ?>
<main class="main-content">
