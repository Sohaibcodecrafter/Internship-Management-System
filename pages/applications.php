<?php
$pageTitle = 'Applications';
require_once __DIR__ . '/../includes/header.php';
$pdo = getDB();

// Handle status update (DML UPDATE)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    requireRole('admin');
    $app_id    = (int)$_POST['application_id'];
    $newStatus = $_POST['status'];

    if (in_array($newStatus, ['pending','shortlisted','accepted','rejected'])) {
        $stmt = $pdo->prepare("
            UPDATE applications
            SET status = ?, reviewed_at = NOW()
            WHERE application_id = ?
        ");
        $stmt->execute([$newStatus, $app_id]);

        // If accepted → auto-create placement record
        if ($newStatus === 'accepted') {
            $internship = $pdo->prepare("
                SELECT i.start_date, i.end_date, i.stipend
                FROM applications a
                INNER JOIN internships i ON a.internship_id = i.internship_id
                WHERE a.application_id = ?
            ");
            $internship->execute([$app_id]);
            $intern = $internship->fetch();

            if ($intern) {
                $check = $pdo->prepare('SELECT placement_id FROM placements WHERE application_id = ?');
                $check->execute([$app_id]);
                if (!$check->fetch()) {
                    $ins = $pdo->prepare('INSERT INTO placements (application_id, start_date, end_date, actual_stipend) VALUES (?,?,?,?)');
                    $ins->execute([$app_id, $intern['start_date'], $intern['end_date'], $intern['stipend']]);
                }
            }
        }
    }
    header('Location: applications.php');
    exit;
}

// Fetch all applications with joins
$search = trim($_GET['search'] ?? '');
$status = $_GET['status'] ?? '';

$where  = ['1=1'];
$params = [];

if ($search !== '') {
    $where[]  = '(s.full_name LIKE ? OR i.title LIKE ? OR c.company_name LIKE ?)';
    $params   = array_merge($params, ["%$search%", "%$search%", "%$search%"]);
}
if (in_array($status, ['pending','shortlisted','accepted','rejected'])) {
    $where[]  = 'a.status = ?';
    $params[] = $status;
}

$stmt = $pdo->prepare("
    SELECT a.application_id, a.status, a.applied_at,
           s.full_name AS student_name,
           i.title     AS internship_title,
           c.company_name,
           CONCAT(SUBSTRING(a.cover_note, 1, 60), '...') AS note_preview
    FROM applications a
    INNER JOIN students    s ON a.student_id    = s.student_id
    INNER JOIN internships i ON a.internship_id = i.internship_id
    INNER JOIN companies   c ON i.company_id    = c.company_id
    WHERE " . implode(' AND ', $where) . "
    ORDER BY a.applied_at DESC
");
$stmt->execute($params);
$applications = $stmt->fetchAll();

require_once __DIR__ . '/applications_view.php';
require_once __DIR__ . '/../includes/footer.php';
