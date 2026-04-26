<?php
$pageTitle = 'Applicants';
require_once __DIR__ . '/../includes/header.php';
requireRole('company');
$pdo = getDB();
$userId = currentUserId();

$company = $pdo->prepare('SELECT * FROM companies WHERE user_id = ?');
$company->execute([$userId]);
$company = $company->fetch();
if (!$company || !$company['verified']) { header('Location: company_dashboard.php'); exit; }
$cid = $company['company_id'];

// Handle status change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $appId = (int)$_POST['application_id'];
    $newStatus = $_POST['new_status'];
    $validStatuses = ['pending', 'shortlisted', 'accepted', 'rejected'];
    if (in_array($newStatus, $validStatuses)) {
        // Verify this application belongs to this company
        $check = $pdo->prepare('SELECT a.application_id, a.student_id, i.title, s.user_id AS student_user_id FROM applications a JOIN internships i ON a.internship_id = i.internship_id JOIN students s ON a.student_id = s.student_id WHERE a.application_id = ? AND i.company_id = ?');
        $check->execute([$appId, $cid]);
        $app = $check->fetch();
        if ($app) {
            $pdo->beginTransaction();
            $pdo->prepare("UPDATE applications SET status = ?, reviewed_at = NOW() WHERE application_id = ?")->execute([$newStatus, $appId]);

            // Auto-create placement if accepted
            if ($newStatus === 'accepted') {
                $intern = $pdo->prepare('SELECT start_date, end_date, stipend FROM internships WHERE internship_id = (SELECT internship_id FROM applications WHERE application_id = ?)');
                $intern->execute([$appId]);
                $iData = $intern->fetch();
                $exists = $pdo->prepare('SELECT COUNT(*) FROM placements WHERE application_id = ?');
                $exists->execute([$appId]);
                if ($exists->fetchColumn() == 0) {
                    $pdo->prepare('INSERT INTO placements (application_id, start_date, end_date, actual_stipend) VALUES (?, ?, ?, ?)')->execute([$appId, $iData['start_date'], $iData['end_date'], $iData['stipend']]);
                }
            }

            // Notify student
            $msg = 'Your application for "' . $app['title'] . '" has been ' . $newStatus . '.';
            $pdo->prepare('INSERT INTO notifications (user_id, message) VALUES (?, ?)')->execute([$app['student_user_id'], $msg]);
            $pdo->commit();
            $_SESSION['flash'] = ['type'=>'success','msg'=>'Application status updated.'];
        }
    }
    header('Location: company_applicants.php' . (!empty($_GET['internship_id']) ? '?internship_id=' . (int)$_GET['internship_id'] : ''));
    exit;
}

// Get company's internships for filter
$myInternships = $pdo->prepare('SELECT internship_id, title FROM internships WHERE company_id = ? ORDER BY start_date DESC');
$myInternships->execute([$cid]);
$myInternships = $myInternships->fetchAll();

// Build query
$where = ['i.company_id = ?'];
$params = [$cid];
if (!empty($_GET['internship_id'])) { $where[] = 'i.internship_id = ?'; $params[] = (int)$_GET['internship_id']; }
if (!empty($_GET['status'])) { $where[] = 'a.status = ?'; $params[] = $_GET['status']; }

$whereClause = implode(' AND ', $where);
$applicants = $pdo->prepare("SELECT a.*, s.full_name, s.email, s.cv_file, i.title AS internship_title,
    (SELECT d.dept_name FROM departments d WHERE d.dept_id = s.dept_id) AS dept_name
    FROM applications a
    JOIN students s ON a.student_id = s.student_id
    JOIN internships i ON a.internship_id = i.internship_id
    WHERE $whereClause
    ORDER BY a.applied_at DESC");
$applicants->execute($params);
$applicants = $applicants->fetchAll();

require_once __DIR__ . '/company_applicants_view.php';
require_once __DIR__ . '/../includes/footer.php';
