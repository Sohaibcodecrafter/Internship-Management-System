<?php
$pageTitle = 'Post Internship';
require_once __DIR__ . '/../includes/header.php';
requireRole('company');
$pdo = getDB();
$userId = currentUserId();

$company = $pdo->prepare('SELECT * FROM companies WHERE user_id = ?');
$company->execute([$userId]);
$company = $company->fetch();
if (!$company) { header('Location: company_dashboard.php'); exit; }

// Check verification + active status
$userStmt = $pdo->prepare('SELECT is_active FROM users WHERE user_id = ?');
$userStmt->execute([$userId]);
$userActive = $userStmt->fetchColumn();

if (!$userActive || !$company['verified']) {
    $blocked = true;
    $requested = (bool)($company['verification_requested'] ?? 0);
    require_once __DIR__ . '/company_post_internship_view.php';
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

$blocked = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $domain = trim($_POST['domain'] ?? '');
    $stipend = (float)($_POST['stipend'] ?? 0);
    $duration = (int)($_POST['duration_months'] ?? 0);
    $startDate = $_POST['start_date'] ?? '';
    $endDate = $_POST['end_date'] ?? '';
    $slots = max(1, (int)($_POST['slots'] ?? 1));

    $errors = [];
    if (empty($title)) $errors[] = 'Title is required.';
    if (empty($domain)) $errors[] = 'Domain/skills is required.';
    if ($duration < 1) $errors[] = 'Duration must be at least 1 month.';
    if (empty($startDate) || strtotime($startDate) < strtotime('today')) $errors[] = 'Start date must be today or in the future.';
    if (empty($endDate) || strtotime($endDate) <= strtotime($startDate)) $errors[] = 'End date must be after start date.';

    if (!empty($errors)) {
        $error = implode('<br>', $errors);
    } else {
        // ACTUAL schema: internships has NO city, is_paid, is_remote, deadline, posted_at columns
        $stmt = $pdo->prepare("INSERT INTO internships (company_id, title, description, domain, stipend, duration_months, start_date, end_date, slots, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'open')");
        $stmt->execute([$company['company_id'], $title, $description, $domain, $stipend, $duration, $startDate, $endDate, $slots]);
        $_SESSION['flash'] = ['type'=>'success','msg'=>'Internship posted successfully!'];
        header('Location: company_internships.php');
        exit;
    }
}

require_once __DIR__ . '/company_post_internship_view.php';
require_once __DIR__ . '/../includes/footer.php';
