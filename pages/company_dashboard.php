<?php
$pageTitle = 'Company Dashboard';
require_once __DIR__ . '/../includes/header.php';
requireRole('company');
$pdo = getDB();
$userId = currentUserId();

$company = $pdo->prepare('SELECT * FROM companies WHERE user_id = ?');
$company->execute([$userId]);
$company = $company->fetch();

if (!$company || !$company['verified']) {
    echo '<div class="alert alert-error" style="max-width:600px;margin:var(--s5) auto;text-align:center">';
    echo '<h2>Account Pending Verification</h2>';
    echo '<p>Your company account is awaiting admin approval. You will be notified once verified.</p>';
    echo '</div>';
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

$cid = $company['company_id'];
$stats = [];
$stats['total_internships'] = $pdo->prepare('SELECT COUNT(*) FROM internships WHERE company_id = ?');
$stats['total_internships']->execute([$cid]); $stats['total_internships'] = $stats['total_internships']->fetchColumn();

$stats['total_applications'] = $pdo->prepare("SELECT COUNT(*) FROM applications a JOIN internships i ON a.internship_id = i.internship_id WHERE i.company_id = ?");
$stats['total_applications']->execute([$cid]); $stats['total_applications'] = $stats['total_applications']->fetchColumn();

$stats['open_internships'] = $pdo->prepare("SELECT COUNT(*) FROM internships WHERE company_id = ? AND status = 'open'");
$stats['open_internships']->execute([$cid]); $stats['open_internships'] = $stats['open_internships']->fetchColumn();

$stats['accepted_placements'] = $pdo->prepare("SELECT COUNT(*) FROM placements p JOIN applications a ON p.application_id = a.application_id JOIN internships i ON a.internship_id = i.internship_id WHERE i.company_id = ?");
$stats['accepted_placements']->execute([$cid]); $stats['accepted_placements'] = $stats['accepted_placements']->fetchColumn();

// Recent applications
$recentApps = $pdo->prepare("SELECT s.full_name, i.title, a.applied_at, a.status FROM applications a JOIN students s ON a.student_id = s.student_id JOIN internships i ON a.internship_id = i.internship_id WHERE i.company_id = ? ORDER BY a.applied_at DESC LIMIT 5");
$recentApps->execute([$cid]);
$recentApps = $recentApps->fetchAll();

require_once __DIR__ . '/company_dashboard_view.php';
require_once __DIR__ . '/../includes/footer.php';
