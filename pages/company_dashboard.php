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
$data = [];
$data['total_internships'] = $pdo->prepare('SELECT COUNT(*) FROM internships WHERE company_id = ?');
$data['total_internships']->execute([$cid]); $data['total_internships'] = $data['total_internships']->fetchColumn();

$data['total_applications'] = $pdo->prepare("SELECT COUNT(*) FROM applications a JOIN internships i ON a.internship_id = i.internship_id WHERE i.company_id = ?");
$data['total_applications']->execute([$cid]); $data['total_applications'] = $data['total_applications']->fetchColumn();

$data['open_internships'] = $pdo->prepare("SELECT COUNT(*) FROM internships WHERE company_id = ? AND status = 'open'");
$data['open_internships']->execute([$cid]); $data['open_internships'] = $data['open_internships']->fetchColumn();

// Step 10: Accepted placements — join through applications to placements
$placementStmt = $pdo->prepare("
    SELECT COUNT(DISTINCT p.placement_id)
    FROM placements p
    JOIN applications a  ON p.application_id = a.application_id
    JOIN internships i   ON a.internship_id  = i.internship_id
    WHERE i.company_id = ? AND a.status = 'accepted'
");
$placementStmt->execute([$cid]);
$data['accepted_placements'] = $placementStmt->fetchColumn();

$acceptedStmt = $pdo->prepare("
    SELECT COUNT(*) FROM applications a
    JOIN internships i ON a.internship_id = i.internship_id
    WHERE i.company_id = ? AND a.status = 'accepted'
");
$acceptedStmt->execute([$cid]);
$data['accepted_count'] = $acceptedStmt->fetchColumn();

// Recent applications
$recentApps = $pdo->prepare("SELECT s.full_name, i.title, a.applied_at, a.status FROM applications a JOIN students s ON a.student_id = s.student_id JOIN internships i ON a.internship_id = i.internship_id WHERE i.company_id = ? ORDER BY a.applied_at DESC LIMIT 5");
$recentApps->execute([$cid]);
$recentApps = $recentApps->fetchAll();

// Step 11: Pie chart data
$pieStmt = $pdo->prepare("
    SELECT a.status, COUNT(*) AS cnt
    FROM applications a
    JOIN internships i ON a.internship_id = i.internship_id
    WHERE i.company_id = ?
    GROUP BY a.status
");
$pieStmt->execute([$cid]);
$pieRows = $pieStmt->fetchAll(PDO::FETCH_ASSOC);
$pieData = ['pending'=>0,'shortlisted'=>0,'accepted'=>0,'rejected'=>0];
foreach ($pieRows as $row) {
    if (isset($pieData[$row['status']])) $pieData[$row['status']] = (int)$row['cnt'];
}
$data['pie_json'] = json_encode($pieData);

require_once __DIR__ . '/company_dashboard_view.php';
require_once __DIR__ . '/../includes/footer.php';
