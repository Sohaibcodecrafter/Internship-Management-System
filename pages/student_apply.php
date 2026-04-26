<?php
$pageTitle = 'Apply for Internship';
require_once __DIR__ . '/../includes/header.php';
requireRole('student');
$pdo = getDB();
$userId = currentUserId();

$student = $pdo->prepare('SELECT * FROM students WHERE user_id = ?');
$student->execute([$userId]);
$student = $student->fetch();

$internshipId = (int)($_GET['internship_id'] ?? 0);
$intern = $pdo->prepare("SELECT i.*, c.company_name, c.city AS company_city, c.company_id
    FROM internships i JOIN companies c ON i.company_id = c.company_id
    WHERE i.internship_id = ? AND i.status = 'open'");
$intern->execute([$internshipId]);
$intern = $intern->fetch();

if (!$intern) {
    $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Internship not found or closed.'];
    header('Location: student_internships.php');
    exit;
}

// Check duplicate
$dup = $pdo->prepare('SELECT COUNT(*) FROM applications WHERE student_id = ? AND internship_id = ?');
$dup->execute([$student['student_id'], $internshipId]);
$alreadyApplied = $dup->fetchColumn() > 0;

if ($alreadyApplied) {
    $_SESSION['flash'] = ['type' => 'error', 'msg' => 'You have already applied for this internship.'];
    header('Location: student_applications.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $coverNote = trim($_POST['cover_note'] ?? '');
    if (strlen($coverNote) < 100) {
        $error = 'Cover letter must be at least 100 characters.';
    } else {
        $pdo->beginTransaction();
        try {
            $ins = $pdo->prepare("INSERT INTO applications (student_id, internship_id, cover_note, status) VALUES (?, ?, ?, 'pending')");
            $ins->execute([$student['student_id'], $internshipId, $coverNote]);

            // Notify company
            $cuStmt = $pdo->prepare('SELECT user_id FROM companies WHERE company_id = ?');
            $cuStmt->execute([$intern['company_id']]);
            $companyUserId = $cuStmt->fetchColumn();
            if ($companyUserId) {
                $msg = 'New application received for "' . $intern['title'] . '" from ' . $student['full_name'];
                $pdo->prepare('INSERT INTO notifications (user_id, message) VALUES (?, ?)')->execute([$companyUserId, $msg]);
            }
            $pdo->commit();
            $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Application submitted successfully!'];
            header('Location: student_applications.php');
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = 'Submission failed. Please try again.';
        }
    }
}

require_once __DIR__ . '/student_apply_view.php';
require_once __DIR__ . '/../includes/footer.php';
