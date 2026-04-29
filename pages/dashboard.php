<?php
$pageTitle = 'Dashboard';
require_once __DIR__ . '/../includes/header.php';
$pdo = getDB();

// Aggregate stats for Bento Cards
$stats = [];

$stats['total_students']  = $pdo->query('SELECT COUNT(*) FROM students')->fetchColumn();
$stats['total_companies']  = $pdo->query('SELECT COUNT(*) FROM companies WHERE verified=1')->fetchColumn();
$stats['open_internships'] = $pdo->query("SELECT COUNT(*) FROM internships WHERE status='open'")->fetchColumn();
$stats['total_placements'] = $pdo->query('SELECT COUNT(*) FROM placements')->fetchColumn();
$stats['pending_apps']     = $pdo->query("SELECT COUNT(*) FROM applications WHERE status='pending'")->fetchColumn();
$stats['avg_stipend']      = $pdo->query('SELECT ROUND(AVG(stipend),0) FROM internships')->fetchColumn();

// Recent applications (INNER JOIN)
$recentApps = $pdo->query("
    SELECT s.full_name AS student, i.title AS internship,
           c.company_name, a.status, a.applied_at
    FROM applications a
    INNER JOIN students    s ON a.student_id    = s.student_id
    INNER JOIN internships i ON a.internship_id = i.internship_id
    INNER JOIN companies   c ON i.company_id    = c.company_id
    ORDER BY a.applied_at DESC LIMIT 10
")->fetchAll();

// Top companies by application count
$topCompanies = $pdo->query("
    SELECT c.company_name, COUNT(a.application_id) AS app_count
    FROM companies c
    LEFT JOIN internships  i ON c.company_id    = i.company_id
    LEFT JOIN applications a ON i.internship_id = a.internship_id
    GROUP BY c.company_id, c.company_name
    ORDER BY app_count DESC LIMIT 5
")->fetchAll();

// Computed percentages for progress bars
$totalApps        = max((int)$pdo->query('SELECT COUNT(*) FROM applications')->fetchColumn(), 1);
$totalInternships = max((int)$pdo->query('SELECT COUNT(*) FROM internships')->fetchColumn(), 1);
$totalCompaniesAll= max((int)$pdo->query('SELECT COUNT(*) FROM companies')->fetchColumn(), 1);

$stats['total_applications'] = $totalApps;
$stats['placement_rate']     = round(($stats['total_placements'] / $totalApps) * 100);
$stats['verified_pct']       = round(($stats['total_companies'] / $totalCompaniesAll) * 100);
$stats['open_pct']           = round(($stats['open_internships'] / $totalInternships) * 100);

// Recent activity from applications
$recentActivity = $pdo->query("
    SELECT s.full_name AS student, i.title AS internship,
           a.status, a.applied_at
    FROM applications a
    INNER JOIN students    s ON a.student_id    = s.student_id
    INNER JOIN internships i ON a.internship_id = i.internship_id
    ORDER BY a.applied_at DESC LIMIT 5
")->fetchAll();
?>

<!-- Dashboard view rendered here -->
<?php require_once __DIR__ . '/dashboard_view.php'; ?>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
