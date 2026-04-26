<?php
$pageTitle = 'Notifications';
require_once __DIR__ . '/../includes/header.php';
$pdo = getDB();
$userId = currentUserId();

// Mark all as read
$pdo->prepare('UPDATE notifications SET is_read = 1 WHERE user_id = ?')->execute([$userId]);

$stmt = $pdo->prepare('SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC');
$stmt->execute([$userId]);
$notifications = $stmt->fetchAll();

require_once __DIR__ . '/notifications_view.php';
require_once __DIR__ . '/../includes/footer.php';
