<?php
$pageTitle = 'Rate Company';
require_once __DIR__ . '/../includes/header.php';
requireRole('student');
$pdo = getDB();
$userId = currentUserId();

$student = $pdo->prepare('SELECT student_id FROM students WHERE user_id = ?');
$student->execute([$userId]);
$studentId = $student->fetchColumn();
$companyId = (int)($_GET['company_id'] ?? 0);

$company = $pdo->prepare('SELECT * FROM companies WHERE company_id = ?');
$company->execute([$companyId]);
$company = $company->fetch();
if (!$company) { $_SESSION['flash'] = ['type'=>'error','msg'=>'Company not found.']; header('Location: student_applications.php'); exit; }

// Check already reviewed
$existing = $pdo->prepare('SELECT COUNT(*) FROM reviews WHERE student_id = ? AND company_id = ?');
$existing->execute([$studentId, $companyId]);
if ($existing->fetchColumn() > 0) { $_SESSION['flash'] = ['type'=>'error','msg'=>'You already reviewed this company.']; header('Location: student_applications.php'); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = (int)($_POST['rating'] ?? 0);
    $comment = trim($_POST['comment'] ?? '');
    if ($rating < 1 || $rating > 5) $error = 'Please select a rating (1-5).';
    else {
        $stmt = $pdo->prepare('INSERT INTO reviews (student_id, company_id, rating, comment) VALUES (?, ?, ?, ?)');
        $stmt->execute([$studentId, $companyId, $rating, $comment ?: null]);
        $_SESSION['flash'] = ['type'=>'success','msg'=>'Review submitted. Thank you!'];
        header('Location: student_applications.php');
        exit;
    }
}
require_once __DIR__ . '/student_rate_view.php';
require_once __DIR__ . '/../includes/footer.php';
