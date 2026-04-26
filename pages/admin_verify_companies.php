<?php
$pageTitle = 'Verify Companies';
require_once __DIR__ . '/../includes/header.php';
requireRole('admin');
$pdo = getDB();

// Handle approve/reject
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $companyId = (int)($_POST['company_id'] ?? 0);
    if (isset($_POST['approve'])) {
        $pdo->prepare('UPDATE companies SET verified = 1, verification_requested = 0 WHERE company_id = ?')->execute([$companyId]);
        // Notify company user
        $cu = $pdo->prepare('SELECT user_id FROM companies WHERE company_id = ?');
        $cu->execute([$companyId]);
        $companyUserId = $cu->fetchColumn();
        if ($companyUserId) {
            $pdo->prepare('INSERT INTO notifications (user_id, message) VALUES (?, ?)')->execute([$companyUserId, 'Your company account has been verified. You can now post internships.']);
        }
        $_SESSION['flash'] = ['type'=>'success','msg'=>'Company approved successfully.'];
    } elseif (isset($_POST['reject'])) {
        $pdo->prepare('UPDATE companies SET verification_requested = 0 WHERE company_id = ?')->execute([$companyId]);
        // Notify company user
        $cu = $pdo->prepare('SELECT user_id FROM companies WHERE company_id = ?');
        $cu->execute([$companyId]);
        $companyUserId = $cu->fetchColumn();
        if ($companyUserId) {
            $pdo->prepare('INSERT INTO notifications (user_id, message) VALUES (?, ?)')->execute([$companyUserId, 'Your company verification request was declined. Please contact admin for details.']);
        }
        $_SESSION['flash'] = ['type'=>'success','msg'=>'Company verification rejected.'];
    }
    header('Location: admin_verify_companies.php'); exit;
}

// Show both unverified AND re-verification requests
$pending = $pdo->query("SELECT c.*, u.username, u.created_at AS reg_date, u.is_active
    FROM companies c JOIN users u ON c.user_id = u.user_id
    WHERE c.verified = 0 OR c.verification_requested = 1
    ORDER BY c.verification_requested DESC, u.created_at ASC")->fetchAll();

require_once __DIR__ . '/admin_verify_companies_view.php';
require_once __DIR__ . '/../includes/footer.php';
