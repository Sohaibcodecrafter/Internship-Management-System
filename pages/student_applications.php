<?php
$pageTitle = 'My Applications';
require_once __DIR__ . '/../includes/header.php';
requireRole('student');
$pdo = getDB();
$userId = currentUserId();

$student = $pdo->prepare('SELECT student_id FROM students WHERE user_id = ?');
$student->execute([$userId]);
$studentId = $student->fetchColumn();

$apps = $pdo->prepare('
    SELECT a.application_id, a.status AS app_status, a.applied_at, a.cover_note,
           i.title AS internship_title, i.stipend,
           c.company_name, c.company_id, c.city AS company_city,
           p.placement_id
    FROM applications a
    JOIN internships i ON a.internship_id = i.internship_id
    JOIN companies c ON i.company_id = c.company_id
    LEFT JOIN placements p ON p.application_id = a.application_id
    WHERE a.student_id = ?
    ORDER BY a.applied_at DESC
');
$apps->execute([$studentId]);
$applications = $apps->fetchAll();

require_once __DIR__ . '/student_applications_view.php';
require_once __DIR__ . '/../includes/footer.php';
