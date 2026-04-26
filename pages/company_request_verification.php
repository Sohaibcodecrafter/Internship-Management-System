<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
requireLogin();
requireRole('company');
$userId = currentUserId();
$pdo = getDB();

// Get company
$stmt = $pdo->prepare('SELECT * FROM companies WHERE user_id = ?');
$stmt->execute([$userId]);
$company = $stmt->fetch();

if ($company && !$company['verification_requested']) {
    // Mark as requested
    $pdo->prepare('UPDATE companies SET verification_requested = 1 WHERE company_id = ?')->execute([$company['company_id']]);

    // Notify ALL admins
    $admins = $pdo->query("SELECT user_id FROM users WHERE role='admin'")->fetchAll();
    $notif = $pdo->prepare('INSERT INTO notifications (user_id, message) VALUES (?, ?)');
    foreach ($admins as $admin) {
        $notif->execute([$admin['user_id'], 'Company "' . $company['company_name'] . '" has requested verification.']);
    }
    $_SESSION['flash'] = ['type'=>'success','msg'=>'Verification request sent. Admin will review shortly.'];
} else {
    $_SESSION['flash'] = ['type'=>'error','msg'=>'Verification request already submitted.'];
}

header('Location: company_post_internship.php');
exit;
