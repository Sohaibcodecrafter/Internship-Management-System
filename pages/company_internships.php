<?php
$pageTitle = 'My Internships';
require_once __DIR__ . '/../includes/header.php';
requireRole('company');
$pdo = getDB();
$userId = currentUserId();

$company = $pdo->prepare('SELECT * FROM companies WHERE user_id = ?');
$company->execute([$userId]);
$company = $company->fetch();
if (!$company || !$company['verified']) { header('Location: company_dashboard.php'); exit; }
$cid = $company['company_id'];

// Handle status toggle (open ↔ closed)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_status'])) {
    $iid = (int)$_POST['internship_id'];
    $currentStatus = $_POST['current_status'] ?? '';
    $newStatus = ($currentStatus === 'open') ? 'closed' : 'open';

    // Verify ownership
    $own = $pdo->prepare('SELECT COUNT(*) FROM internships WHERE internship_id = ? AND company_id = ?');
    $own->execute([$iid, $cid]);
    if ($own->fetchColumn() > 0) {
        $pdo->prepare('UPDATE internships SET status = ? WHERE internship_id = ?')->execute([$newStatus, $iid]);
        $msg = $newStatus === 'open' ? 'Internship reopened.' : 'Internship closed.';
        $_SESSION['flash'] = ['type'=>'success','msg'=>$msg];
    }
    header('Location: company_internships.php'); exit;
}

// Handle delete (only if 0 applications)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $iid = (int)$_POST['internship_id'];
    $appCount = $pdo->prepare('SELECT COUNT(*) FROM applications WHERE internship_id = ?');
    $appCount->execute([$iid]);
    if ($appCount->fetchColumn() == 0) {
        $pdo->prepare('DELETE FROM internships WHERE internship_id = ? AND company_id = ?')->execute([$iid, $cid]);
        $_SESSION['flash'] = ['type'=>'success','msg'=>'Internship deleted.'];
    } else {
        $_SESSION['flash'] = ['type'=>'error','msg'=>'Cannot delete: applications exist.'];
    }
    header('Location: company_internships.php'); exit;
}

$internships = $pdo->prepare("SELECT i.*, (SELECT COUNT(*) FROM applications a WHERE a.internship_id = i.internship_id) AS app_count FROM internships i WHERE i.company_id = ? ORDER BY i.start_date DESC");
$internships->execute([$cid]);
$internships = $internships->fetchAll();

require_once __DIR__ . '/company_internships_view.php';
require_once __DIR__ . '/../includes/footer.php';
