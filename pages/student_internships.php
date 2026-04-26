<?php
$pageTitle = 'Browse Internships';
require_once __DIR__ . '/../includes/header.php';
requireRole('student');
$pdo = getDB();
$userId = currentUserId();

$student = $pdo->prepare('SELECT student_id FROM students WHERE user_id = ?');
$student->execute([$userId]);
$student = $student->fetch();
$studentId = $student['student_id'];

// Build query with filters
// NOTE: internships table has NO city/deadline/is_paid/is_remote columns
// Use company city, start_date for "upcoming", domain for skills
$where = ["i.status = 'open'", "c.verified = 1"];
$params = [];

if (!empty($_GET['city'])) {
    $where[] = 'c.city = ?';
    $params[] = $_GET['city'];
}
if (!empty($_GET['is_paid'])) {
    $where[] = 'i.stipend > 0';
}
if (!empty($_GET['domain'])) {
    $where[] = 'i.domain LIKE ?';
    $params[] = '%' . $_GET['domain'] . '%';
}
if (!empty($_GET['stipend_min']) && is_numeric($_GET['stipend_min'])) {
    $where[] = 'i.stipend >= ?';
    $params[] = (float)$_GET['stipend_min'];
}

$whereClause = implode(' AND ', $where);

// Pagination
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 9;
$offset = ($page - 1) * $perPage;

$countStmt = $pdo->prepare("SELECT COUNT(*) FROM internships i JOIN companies c ON i.company_id = c.company_id WHERE $whereClause");
$countStmt->execute($params);
$total = $countStmt->fetchColumn();
$totalPages = max(1, ceil($total / $perPage));

$stmt = $pdo->prepare("SELECT i.*, c.company_name, c.city AS company_city, c.company_id
    FROM internships i JOIN companies c ON i.company_id = c.company_id
    WHERE $whereClause ORDER BY i.start_date DESC LIMIT $perPage OFFSET $offset");
$stmt->execute($params);
$internships = $stmt->fetchAll();

// Get student's applied internship IDs
$appliedStmt = $pdo->prepare('SELECT internship_id FROM applications WHERE student_id = ?');
$appliedStmt->execute([$studentId]);
$appliedIds = $appliedStmt->fetchAll(PDO::FETCH_COLUMN);

$cities = ['Karachi','Lahore','Islamabad','Peshawar','Quetta','Multan','Faisalabad','Hyderabad'];

require_once __DIR__ . '/student_internships_view.php';
require_once __DIR__ . '/../includes/footer.php';
